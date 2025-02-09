@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<form class="purchase-form" method="post" action="{{url('/purchase/' . $item['id'])}}">
    @csrf
    @livewire('purchase-form', ['item'=>$item, 'profile'=>$profile])
</form>
@endsection