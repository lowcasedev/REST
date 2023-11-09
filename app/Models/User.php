<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'login',
        'password',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }
}
