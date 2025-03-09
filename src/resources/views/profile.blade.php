@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
@if (session('message'))
    <div class="alert-success">
        {{ session('message') }}
    </div>
@endif
<div class="content">
    <h1 class="title">プロフィール設定</h1>
    <form class="profile-form" action="/mypage/profile" method="post">
        @csrf
        @if ($profile->exists)
            @method('PATCH')
        @endif
        @livewire('profile-image-uploader', ['profile'=>$profile])
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">ユーザー名</span>
            </div>
            <input type="text" class="form-item__input" name="name" value="{{old('name') ?? $user->name}}">
            <div class="form-error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">郵便番号</span>
            </div>
            <input type="text" class="form-item__input" name="postal_code" value="{{old('postal_code') ?? $profile->postal_code}}">
            <div class="form-error">
                @error('postal_code')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">住所</span>
            </div>
            <input type="text" class="form-item__input" name="address" value="{{old('address') ?? $profile->address}}">
            <div class="form-error">
                @error('address')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <div class="form-item__name">
                <span class="form-item__label">建物名</span>
            </div>
            <input type="text" class="form-item__input" name="building" value="{{old('building') ?? $profile->building}}">
            <div class="form-error">
                @error('building')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-button">
            <button class="form-button__submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection