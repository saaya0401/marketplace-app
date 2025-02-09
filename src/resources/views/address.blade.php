@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/address.css')}}">
@endsection

@section('content')
<div class="address-content">
    <div class="address-title">
        <h1 class="address-title__name">住所の変更</h1>
    </div>
    <form action="{{url('/purchase/address/' . $item['id'])}}" class="address-form" method="post">
        @csrf
        @method('patch')
        <div class="address-form__item">
            <h3 class="address-form__item-title">郵便番号</h3>
            <input type="text" name="postal_code" value="{{old('postal_code')}}" class="address-form__item-input">
            <div class="form-error">
                @error('postal_code')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="address-form__item">
            <h3 class="address-form__item-title">住所</h3>
            <input type="text" name="address" value="{{old('address')}}" class="address-form__item-input">
            <div class="form-error">
                @error('address')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="address-form__item">
            <h3 class="address-form__item-title">建物名</h3>
            <input type="text" name="building" value="{{old('building')}}" class="address-form__item-input">
            <div class="form-error">
                @error('building')
                {{$message}}
                @enderror
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{Auth::id()}}">
        <div class="address-form__button">
            <button class="address-form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection