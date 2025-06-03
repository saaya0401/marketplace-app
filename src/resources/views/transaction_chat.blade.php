@extends('layouts.register_login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction_chat.css') }}">
@endsection

@section('side')
<div class="side">
    <p class="side-menu__title">その他の取引</p>
    <ul class="side-menu__list">
        <li class="side-menu__list-title">商品名</li>
        <li class="side-menu__list-title">商品名</li>
        <li class="side-menu__list-title">商品名</li>
    </ul>
</div>
@endsection

@section('content')
<div class="content">
    <div class="chat-header">
        <div class="header-user__info">
            <img src="" alt="アイコン" class="header-user__image">
            <h2 class="header-title">
                「<span class="header-user__name">ユーザー名</span>」さんとの取引画面
            </h2>
        </div>
        <form action="" method="post" class="complete-button">
            @csrf
            @method('patch')
            <button class="complete-form__button">取引を完了する</button>
        </form>
    </div>
    <div class="transaction-item">
        <img src="" alt="商品画像" class="transaction-item__image">
        <div class="transaction-item__info">
            <h1 class="transaction-item__title">商品名</h1>
            <h3 class="transaction-item__price">商品価格</h3>
        </div>
    </div>
    <div class="chat-area">
        <div class="chat-content">
            <div class="chat__user-info">
                <img src="" alt="アイコン" class="chat__user-image">
                <h6 class="chat__user-name">ユーザー名</h6>
            </div>
            <div class="chat-message">ff</div>
        </div>
        <div class="chat-content__self">
            <div class="chat__user-info--self">
                <h6 class="chat__user-name">ユーザー名</h6>
                <img src="" alt="アイコン" class="chat__user-image">
            </div>
            <form class="chat-message__form">
                @csrf
                <input type="text" class="chat-message__input">
                <div class="chat-message__button">
                    <button class="chat-message__button-action" formaction="" formmethod="">編集</button>
                    <button class="chat-message__button-action" formaction="" formmethod="">削除</button>
                </div>
            </form>
        </div>
    </div>
    <form action="" method="post" class="message-form">
        @csrf
        <textarea name="body" placeholder="取引メッセージを記入してください" class="message-textarea"></textarea>
        @livewire('chat-message-image')
        <button class="message-form__button">
            <img src="{{ asset('/icon/send.png') }}" alt="" class="message-form__button-image">
        </button>
    </form>
</div>
@endsection