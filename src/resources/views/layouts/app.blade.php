<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- ← 追加! --}}
    <title>@yield('title', 'MyApp')</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>

<body>

<header class="header">
    <div class="header__inner">

        {{-- ロゴ --}}
        <div class="header__logo">
            <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
        </div>

        {{-- 検索フォーム --}}
        <div class="header__search">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input 
                    type="text" 
                    name="keyword" 
                    class="search-input" 
                    placeholder="なにをお探しですか？"
                    value="{{ request('keyword') }}"
                >

            </form>
        </div>

        {{-- ログイン後のナビゲーション --}}
<nav class="header__nav">
    @auth
        {{-- ログイン中 --}}
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ログアウト
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <a href="{{ route('mypage') }}">マイページ</a>

        {{-- 出品画面（GET） --}}
        <a href="{{ route('sell.create') }}" class="sell-btn">出品</a>
    @endauth

    @guest
        {{-- 未ログイン --}}
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('mypage') }}">マイページ</a>

        {{-- 未ログインでも出品画面へ（authでリダイレクトされる） --}}
        <a href="{{ route('sell.create') }}" class="sell-btn">出品</a>
    @endguest
</nav>

</header>

<main class="main">
    @yield('content')
</main>

</body>
</html>
