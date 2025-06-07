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
                <img src="{{ Storage::url(Auth::id() === $item->user->id ? ($buyer->profile_image ?? '') : ($item->user->profile->profile_image ?? '')) }}" alt="アイコン" class="header-user__image">
                <h2 class="header-title">
                    「<span class="header-user__name">
                        @if(Auth::id() === $item->user->id)
                            {{ $buyer->user->name}}
                        @else
                            {{ $item->user->name }}
                        @endif
                    </span>」さんとの取引画面
                </h2>
            </div>
                @livewire('rating-modal', ['item'=>$item])
        </div>
        <div class="transaction-item">
            <img src="{{ Storage::url($item->image) }}" alt="商品画像" class="transaction-item__image">
            <div class="transaction-item__info">
                <h1 class="transaction-item__title">{{ $item->title }}</h1>
                <h3 class="transaction-item__price">{{ $item->getFormattedPriceAttribute() }}</h3>
            </div>
        </div>
        <div class="chat-area">
            @foreach($transactionMessages as $transactionMessage)
            @if($transactionMessage->user_id !== Auth::id())
                <div class="chat-content">
                    <div class="chat__user-info">
                        <img src="{{ Storage::url(Auth::id() === $item->user->id ? ($buyer->profile_image ?? '') : ($item->user->profile->profile_image ?? '')) }}" alt="アイコン" class="chat__user-image">
                        <h6 class="chat__user-name">
                            @if(Auth::id() === $item->user->id)
                                {{ $buyer->user->name}}
                            @else
                                {{ $item->user->name }}
                            @endif
                        </h6>
                    </div>
                    <div class="chat-message">
                        {{ $transactionMessage->body }}
                    </div>
                    @if($transactionMessage->message_image)
                        <img src="{{ Storage::url($transactionMessage->message_image) }}" alt="画像" class="message-img">
                    @endif
                </div>
            @else
                <div class="chat-content__self">
                    <div class="chat__user-info--self">
                        <h6 class="chat__user-name">{{ $self->user->name }}</h6>
                        <img src="{{ Storage::url($self->profile_image) }}" alt="アイコン" class="chat__user-image">
                    </div>
                    @if($transactionMessage->message_image)
                        <img src="{{ Storage::url($transactionMessage->message_image) }}" alt="画像" class="message-img">
                    @endif
                    <div class="message-form__area">
                        <form class="chat-message__form" method="post" action="{{ url('/message/edit/' . $item->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="text" class="chat-message__input" name="edit_body" placeholder="{{ $transactionMessage->body }}">
                            <input type="hidden" name="id" value="{{ $transactionMessage->id }}">
                            <div class="chat-message__button">
                                @if(old('id') == $transactionMessage->id)
                                <div class="form-error">
                                    @error('edit_body')
                                        {{ $message }}
                                    @enderror
                                </div>
                                @endif
                                <button class="chat-message__button-action" type="submit">編集</button>
                            </div>
                        </form>
                        <form class="chat-message__button-delete" action="{{ url('/message/delete/' . $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $transactionMessage->id }}">
                            <button class="chat-message__button-action" type="submit">削除</button>
                        </form>
                    </div>
                </div>
            @endif
            @endforeach
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
                <textarea name="body" placeholder="取引メッセージを記入してください" class="message-textarea">{{ old('body') }}</textarea>
            </div>
            @livewire('chat-message-image')
            <input type="hidden" name="user_id" value="{{ $self->user->id }}">
            <input type="hidden" name="purchase_id" value="{{ $item->purchase->id }}">
            <button class="message-form__button" type="submit">
                <img src="{{ asset('/icon/send.png') }}" alt="" class="message-form__button-image">
            </button>
        </form>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.querySelector('.message-textarea');
        const itemId="{{ $item->id }}";
        const key = 'chat_draft_body_' + itemId;

        const savedText = sessionStorage.getItem(key);
        if (savedText) {
            textarea.value = savedText;
        }

        textarea.addEventListener('input', function () {
            sessionStorage.setItem(key, textarea.value);
        });

        document.querySelector('.message-form')?.addEventListener('submit', function () {
            sessionStorage.removeItem(key);
        });
    });
</script>
@endsection