@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="tab-area">
    <div class="tab-buttons">
        <a href="{{url('/')}}" class="tab-button {{$tab !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="{{url('/?tab=mylist')}}" class="tab-button {{$tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
</div>
<div class="content">
    @foreach($items as $item)
    <form class="item-card__form" action="{{url('/item/' . $item['id'])}}" method="get">
        @csrf
        <button class="item-card__button" type="submit">
            <div class="item-card__image">
                <img src="{{ Storage::url($item['image'])}}" alt="商品画像" class="item-card__img">
            </div>
            <div class="item-card__title">
                <span class="item-card__name">{{$item['title']}}</span>
            </div>
        </button>
    </form>
    @endforeach
</div>
@endsection