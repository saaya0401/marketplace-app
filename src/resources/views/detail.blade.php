@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="detail-image">
        <img src="{{Storage::url($item['image'])}}" alt="商品画像" class="detail-img">
    </div>
    <div class="detail-content">
        <div class="item-title">
            <h1 class="item-title__name">{{$item['title']}}</h1>
            <h6 class="item-title__brand">{{$item['user']['name']}}</h6>
            <h3 class="item-title__price">&yen;{{$item['price']}}（税込）</h3>
        </div>
        <div class="item-actions">
            <div class="item-actions__icons">
                <img src="{{asset('icon/star.png')}}" alt="星のアイコン" class="item-actions__icon--star">
                <img src="{{asset('icon/chat.png')}}" alt="吹き出しのアイコン" class="item-actions__icon--chat">
            </div>
            <div class="item-actions__counts">
                <small class="item-actions__count--mylist">3</small>
                <small class="item-actions__count--comment">1</small>
            </div>
        </div>
        <form class="item-purchase__form" action="{{url('/purchase/' . $item['id'])}}" method="get">
            @csrf
            <button class="item-purchase__form-button" type="submit">購入手続きへ</button>
        </form>
        <div class="item-description">
            <h2 class="item-description__title">商品説明</h2>
            <p class="item-description__text">{{$item['description']}}</p>
        </div>
        <div class="item-info">
            <h2 class="item-info__title">商品の情報</h2>
            <table class="item-info__table">
                <tr class="item-info__table--row">
                    <th class="item-info__table--header">カテゴリー</th>
                    <td class="item-info__table--categories">
                        @foreach($item->categories as $category)
                        <div class="item-info__table--category">{{$category['name']}}</div>
                        @endforeach
                    </td>
                </tr>
                <tr class="item-info__table--row">
                    <th class="item-info__table--header">商品の状態</th>
                    <td class="item-info__table--condition">
                        {{$item['condition']['condition']}}
                    </td>
                </tr>
            </table>
            <div class="item-comments">
                <h2 class="item-comments__title">コメント(1)</h2>
                <div class="item-comments__list">
                    <div class="item-comments__user-profile"></div>
                    <div class="item-comments__user-name">admin</div>
                    <div class="item-comments__text">
                        こちらにコメントが入ります
                    </div>
                </div>
                <div class="item-comment__input-area">
                    <h3 class="item-comment__input-title">商品へのコメント</h3>
                    <form action="{{url('/comment/' . $item['id'])}}" method="post" class="item-comment__form">
                        @csrf
                        <textarea name="content" class="item-comment__textarea">{{old('content')}}</textarea>
                        <button class="item-comment__button" type="submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection