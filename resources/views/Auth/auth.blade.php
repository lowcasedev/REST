<!doctype html>
<html lang=ru>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <title>NoteBook || Auth</title>
</head>
<body>
<div class="login-page">
    <div class="form">
        <form class="register-form" method="post" action="{{route('register')}}">
            @csrf
            <input type="text" name="register-login" placeholder="Логин"/>
            <input type="password" name="register-password" placeholder="Пароль"/>
            <input type="text" name="register-password-again" placeholder="Повторите пароль"/>
            <button>create</button>
            <p class="message">Уже есть аккаунт? <a href="#">Войдите!</a></p>
        </form>
        <form class="login-form" method="POST" action="{{route('login')}}">
            @csrf
            <input type="text" name="login-login" placeholder="Логин"/>
            <input type="password" name="login-password" placeholder="Пароль"/>
            <button>login</button>
            <p class="message">Ещё нет аккаунта? <a href="#">Создайте прямо сейчас!</a></p>
        </form>
    </div>
</div>
</body>

<script>
    $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
</script>

</html>




