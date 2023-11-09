<?php

namespace App\Http\Controllers\Encryption;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    private mixed $key;
    private mixed $iv;

    public function __construct()
    {
        $this->key = env("SECRET_KEY");
        $this->iv = env("IV");
    }

    public function encrypt($data) : string
    {
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr(hash('sha256', $this->iv), 0, $iv_size);

        return openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);
    }

    public function decrypt($data) : string
    {
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr(hash('sha256', $this->iv), 0, $iv_size);

        return openssl_decrypt($data, 'aes-256-cbc', $this->key, 0, $iv);
    }
}
