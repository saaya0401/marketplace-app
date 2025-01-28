@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
<div class="content">
    <h1 class="title">プロフィール設定</h1>
    <form class="profile-form" action="/profile" method="post">
        @csrf
        @livewire('profile-image-uploader')
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">ユーザー名</span>
            </div>
            <input type="text" class="form-item__input" name="name" value="{{old('name') ?? $user->name}}">
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">郵便番号</span>
            </div>
            <input type="text" class="form-item__input" name="postal_code" value="{{old('postal_code')}}">
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">住所</span>
            </div>
            <input type="text" class="form-item__input" name="address" value="{{old('address')}}">
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">建物名</span>
            </div>
            <input type="text" class="form-item__input" name="building" value="{{old('building')}}">
        </div>
        <div class="form-button">
            <button class="form-button__submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection