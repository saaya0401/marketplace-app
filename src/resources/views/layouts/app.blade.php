<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
    @livewireStyles
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <div class="header__logo">
                <img src="{{asset('icon/Vector.png')}}" alt="アイコン" class="header__logo-icon">
                <img src="{{asset('icon/COACHTECH.png')}}" alt="COACHTECH" class="header__logo-title">
            </div>
            <form class="header-search__form" method="get" action="/item/search">
                @csrf
                <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{old('keyword', request('keyword'))}}" class="header-search__form--input">
                <div class="header-search__form--button">
                    <button class="header-search__form--button-submit" type="submit">検索</button>
                </div>
            </form>
            <nav>
                <ul class="header-nav">
                    <li class="header-nav__item">
                        @if(Auth::check())
                        <form action="/logout" method="post">
                            @csrf
                            <button class="header-nav__button">ログアウト</button>
                        </form>
                        @else
                        <form action="/login" method="get">
                            @csrf
                            <button class="header-nav__button">ログイン</button>
                        </form>
                        @endif
                    </li>
                    <li class="header-nav__item">
                        <form action="">
                            <button class="header-nav__button">マイページ</button>
                        </form>
                    </li>
                    <li class="header-nav__item">
                        <form action="">
                            <button class="header-nav__button-sell">出品</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>