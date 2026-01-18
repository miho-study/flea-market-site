{{-- 送付先住所変更画面 --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">住所の変更</h1>

    <form method="POST" action="{{ route('purchase.address.update', $item_id) }}">
        @csrf

        <div class="address-row">
            {{-- 郵便番号 --}}
            <div class="form-group">
                <label>郵便番号</label>
                <input type="text" name="post_code"
                    value="{{ old('post_code', $address['post_code'] ?? '') }}">
                @error('post_code')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 住所 --}}
            <div class="form-group">
                <label>住所</label>
                <input type="text" name="address"
                    value="{{ old('address', $address['address'] ?? '') }}">
                @error('address')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="form-group">
                <label>建物名</label>
                <input type="text" name="building_name"
                    value="{{ old('building_name', $address['building'] ?? '') }}">
            </div>
        </div>

        <button class="update_btn">更新する</button>
    </form>
</div>

@endsection
