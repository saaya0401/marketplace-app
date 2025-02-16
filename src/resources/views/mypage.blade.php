@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage-user__info">
    <div class="mypage-user__info-header">
        <div class="mypage-user__profile">
            <img src="{{Storage::url($profile->profile_image)}}" alt="" class="mypage-user__profile-image">
        </div>
        <div class="mypage-user__name">{{Auth::user()->name}}</div>
    </div>
    <form action="/mypage/profile" method="get" class="mypage-user__form">
        @csrf
        <button class="mypage-user__button">
            プロフィールを編集
        </button>
    </form>
</div>
<div class="mypage-tab__list">
    <div class="tab-buttons">
        <a href="{{url('/mypage?tab=sell')}}" class="tab-button {{$tab !== 'buy' ? 'active' : '' }}">出品した商品</a>
        <a href="{{url('/mypage?tab=buy')}}" class="tab-button {{$tab === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>
</div>
<div class="mypage-items">
    @foreach($items as $item)
    <form class="item-card__form" action="{{url('/item/' . (isset($item->item) ? $item->item->id : $item->id))}}" method="get">
        @csrf
        <button class="item-card__button" type="submit">
            <div class="item-card__image">
                <img src="{{Storage::Url(isset($item->item) ? $item->item->image : $item->image)}}" alt="商品画像" class="item-card__img">
            </div>
            <div class="item-card__title">
                <span class="item-card__name">{{isset($item->item) ? $item->item->title : $item->title}}</span>
            </div>
        </button>
    </form>
    @endforeach
</div>
@endsection