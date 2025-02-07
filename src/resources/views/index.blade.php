@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="tab-area">
    <div class="tab-buttons">
        <a href="{{url('/?keyword=' . request('keyword'))}}" class="tab-button {{$tab !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="{{url('/?tab=mylist&keyword=' . request('keyword'))}}" class="tab-button {{$tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
</div>
<div class="content">
    @foreach($items as $item)
    <form class="item-card__form" action="{{url('/item/' . (isset($item->item) ? $item->item->id : $item->id))}}" method="get">
        @csrf
        <button class="item-card__button" type="submit">
            <div class="item-card__image">
                <img src="{{ Storage::url(isset($item->item) ? $item->item->image : $item->image)}}" alt="商品画像" class="item-card__img">
            </div>
            <div class="item-card__title">
                <span class="item-card__name">{{isset($item->item) ? $item->item->title : $item->title}}</span>
            </div>
        </button>
    </form>
    @endforeach
</div>
@endsection