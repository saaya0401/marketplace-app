<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/register_login.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a class="header__logo" href="/">
                <img src="{{asset('icon/Vector.png')}}" alt="アイコン" class="header__logo-icon">
                <img src="{{asset('icon/COACHTECH.png')}}" alt="COACHTECH" class="header__logo-title">
            </a>
            @yield('nav')
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>