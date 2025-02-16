@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection

@section('content')
<form class="exhibited-product__form" action="/sell" method="post">
    @csrf
    <h1 class="form-title">商品の出品</h1>
    <div class="exhibited-products">
        <h3 class="exhibited-product__title">商品画像</h3>
        @livewire('image-uploader')
    </div>
    <div class="exhibited-product__detail">
        <div class="exhibited-product__header">
            <h2 class="exhibited-product__header--name">商品の詳細</h2>
        </div>
        <div class="exhibited-product__category">
            <h3 class="exhibited-product__title">カテゴリー</h3>
            <div class="exhibited-product__category-group">
                @foreach($categories as $category)
                <label class="category-checkbox__label"><input type="checkbox" name="categories[]" class="category-checkbox" value="{{$category['id']}}"  @if(in_array($category['id'], old('categories', []))) checked @endif>{{$category['name']}}</label>
                @endforeach
                <div class="form-error">
                    @error('categories')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <div class="exhibited-product__condition">
            <h3 class="exhibited-product__title">商品の状態</h3>
            <div class="exhibited-product__condition-select__area">
                <select name="condition_id" class="exhibited-product__condition-select">
                    <option value="" disabled selected>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{$condition['id']}}" {{old('condition_id') == $condition['id'] ? 'selected' : ''}}>{{$condition['condition']}}</option>
                    @endforeach
                </select>
                <div class="form-error">
                    @error('condition_id')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="exhibited-product__info">
        <div class="exhibited-product__header">
            <h2 class="exhibited-product__header--name">商品名と説明</h2>
        </div>
        <div class="exhibited-product__name">
            <h3 class="exhibited-product__title">商品名</h3>
            <input type="text" name="title" class="exhibited-product__input" value="{{old('title')}}">
            <div class="form-error">
                @error('title')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="exhibited-product__user">
            <h3 class="exhibited-product__title">ブランド名</h3>
            <input type="text" class="exhibited-product__input" value="{{Auth::user()->name}}" readonly>
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <div class="form-error">
                @error('user_id')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="exhibited-product__description">
            <h3 class="exhibited-product__title">商品の説明</h3>
            <textarea name="description" class="exhibited-product__textarea">{{old('description')}}</textarea>
            <div class="form-error">
                @error('description')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="exhibited-product__price">
            <h3 class="exhibited-product__title">販売価格</h3>
            <div class="exhibited-product__price-wrapper">
                <input type="text" name="price" class="exhibited-product__input-price" value="{{old('price')}}">
                <span class="exhibited-product__yen">&yen;</span>
            </div>
            <div class="form-error">
                @error('price')
                {{$message}}
                @enderror
            </div>
        </div>
    </div>
    <div class="exhibited-product__button">
        <button class="exhibited-product__button-submit" type="submit">出品する</button>
    </div>
</form>
@endsection