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
        <div class="mypage-user__data">
            <p class="mypage-user__name">{{Auth::user()->name}}</p>
            <p class="mypage-user__rating">
                @if($averageRating)
                    @for($i=1; $i<=5; $i++)
                        @if($i<= $averageRating)
                            <img src="{{ asset('icon/rating-star-yellow.png') }}" alt="星" class="mypage-user__rating-star">
                        @else
                            <img src="{{ asset('icon/rating-star.png') }}" alt="星" class="mypage-user__rating-star">
                        @endif
                    @endfor
                @endif
            </p>
        </div>
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
        <a href="{{url('/mypage?tab=sell')}}" class="tab-button {{$tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{url('/mypage?tab=buy')}}" class="tab-button {{$tab === 'buy' ? 'active' : '' }}">購入した商品</a>
        <div class="transaction-tab">
            <a href="{{ url('/mypage?tab=transaction') }}" class="tab-button {{ $tab === 'transaction' ? 'active' : '' }}">取引中の商品</a>
            @if($unreadCountAll>0)
                <span class="transaction-message__count">{{ $unreadCountAll }}</span>
            @endif
        </div>
    </div>
</div>
<div class="mypage-items">
    @foreach($items as $item)
    <form class="item-card__form" action="{{ $tab === 'transaction' ? url('/transaction/' . $item->item->id) : url('/item/' . (isset($item->item) ? $item->item->id : $item->id))}}" method="get">
        <button class="item-card__button" type="submit">
            <div class="item-card__image">
                <img src="{{Storage::Url(isset($item->item) ? $item->item->image : $item->image)}}" alt="商品画像" class="item-card__img">
                @if($item->unreadCount>0)
                    <div class="unread-count__circle">
                        <span class="unread-count">{{ $item->unreadCount }}</span>
                    </div>
                @endif
            </div>
            <div class="item-card__title">
                <span class="item-card__name">{{isset($item->item) ? $item->item->title : $item->title}}</span>
            </div>
        </button>
    </form>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('pageshow', function(event){
        if(event.persisted){
            window.location.reload();
        }
    });
</script>
@endsection