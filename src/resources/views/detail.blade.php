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
            <div class="item-title__name-user">
                <h1 class="item-title__name">{{$item['title']}}</h1>
                <h6 class="item-title__brand">{{$item['user']['name']}}</h6>
            </div>
            <h3 class="item-title__price">&yen;<span class="item-price__number">{{$item['price']}}</span>（税込）</h3>
        </div>
        <div class="item-actions">
            <div class="item-actions__icons">
                <form action="{{url('/mylist/' . $item['id'])}}" method="post" class="item-mylist__form">
                    @csrf
                    <button class="item-mylist__form--button" type="submit">
                        <img src="{{asset($isMylisted ? 'icon/star-yellow.png' : 'icon/star.png' )}}" alt="星のアイコン" class="item-actions__icon--star">
                    </button>
                </form>
                <img src="{{asset('icon/chat.png')}}" alt="吹き出しのアイコン" class="item-actions__icon--chat">
            </div>
            <div class="item-actions__counts">
                <small class="item-actions__count--mylist">{{$mylistCount}}</small>
                <small class="item-actions__count--comment">{{$commentCount}}</small>
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
                <h2 class="item-comments__title">コメント({{$commentCount}})</h2>
                @foreach($comments as $comment)
                <div class="item-comments__list">
                    <div class="item-comments__list-profile">
                        <div class="item-comments__user-profile">
                            <img src="{{Storage::url($comment->profile->profile_image)}}" alt="" class="item-comments__profile--image">

                        </div>
                        <div class="item-comments__user-name">
                            {{$comment->profile->user->name}}
                        </div>
                    </div>
                    <div class="item-comments__text">
                        {{$comment['content']}}
                    </div>
                </div>
                @endforeach
                <div class="item-comment__input-area">
                    <h3 class="item-comment__input-title">商品へのコメント</h3>
                    <form action="{{url('/comment/' . $item['id'])}}" method="post" class="item-comment__form">
                        @csrf
                        <textarea name="content" class="item-comment__textarea">{{old('content')}}</textarea>
                        <button class="item-comment__button" type="submit">コメントを送信する</button>
                        <div class="form-error">
                            @error('content')
                            {{$message}}
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection