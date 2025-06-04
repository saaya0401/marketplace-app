@extends('layouts.register_login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction_chat.css') }}">
@endsection

@section('content')
<aside class="aside">
    <div class="side">
        <p class="side-menu__title">その他の取引</p>
        <ul class="side-menu__list">
            @foreach($transactions as $transaction)
            <li class="side-menu__list-title">
                <a href="{{ url('/transaction/' . $transaction->item->id) }}" class="transaction-link">{{ $transaction->item->title }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</aside>
<main class="main">
    <div class="content">
        <div class="chat-header">
            <div class="header-user__info">
                <img src="{{ Storage::url($item->user->profile->profile_image) }}" alt="アイコン" class="header-user__image">
                <h2 class="header-title">
                    「<span class="header-user__name">{{ $item->user->name }}</span>」さんとの取引画面
                </h2>
            </div>
            @if(Auth::id() !== $item->user->id)
            <form action="" method="post" class="complete-button">
                @csrf
                @method('patch')
                <button class="complete-form__button">取引を完了する</button>
            </form>
            @endif
        </div>
        <div class="transaction-item">
            <img src="{{ Storage::url($item->image) }}" alt="商品画像" class="transaction-item__image">
            <div class="transaction-item__info">
                <h1 class="transaction-item__title">{{ $item->title }}</h1>
                <h3 class="transaction-item__price">{{ $item->getFormattedPriceAttribute() }}</h3>
            </div>
        </div>
        <div class="chat-area">
            <div class="chat-content">
                <div class="chat__user-info">
                    <img src="{{ Storage::url($item->user->profile->profile_image) }}" alt="アイコン" class="chat__user-image">
                    <h6 class="chat__user-name">{{ $item->user->name}}</h6>
                </div>
                <div class="chat-message">ff</div>
            </div>
            <div class="chat-content__self">
                <div class="chat__user-info--self">
                    <h6 class="chat__user-name">{{ $self->user->name }}</h6>
                    <img src="{{ Storage::url($self->profile_image) }}" alt="アイコン" class="chat__user-image">
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
        <form action="/transaction/message" method="post" class="message-form">
            @csrf
            <div class="chat-message__area">
                <div class="form-errors">
                    <span class="form-error">
                        @error('body')
                            {{ $message }}
                        @enderror
                    </span>
                    <span class="form-error">
                        @error('message_image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <textarea name="body" placeholder="取引メッセージを記入してください" class="message-textarea"></textarea>
            </div>
            @livewire('chat-message-image')
            <input type="hidden" name="user_id" value="{{ $self->user->id }}">
            <input type="hidden" name="purchase_id" value="{{ $item->purchase->id }}">
            <button class="message-form__button">
                <img src="{{ asset('/icon/send.png') }}" alt="" class="message-form__button-image">
            </button>
        </form>
    </div>
</main>
@endsection