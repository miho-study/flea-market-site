@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="container">

        {{-- プロフィール --}}
        <div class="profile-header">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default.jpeg') }}"
                class="profile-image">

            <h1 class="user-name">{{ Auth::user()->name }}</h1>

            <a href="{{ route('mypage.profile') }}" class="edit-profile-btn">
                プロフィールを編集
            </a>
        </div>

        {{-- タブ --}}
        @php $page = request()->query('page', 'sell'); @endphp
        <div class="tab-menu">
            <a href="{{ route('mypage', ['page' => 'sell']) }}"
                class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
        </div>

        {{-- 出品した商品 --}}
        <div id="selling" class="tab-content {{ $page === 'sell' ? 'active' : '' }}">
            <div class="product-list">
                @forelse ($sellingProducts as $product)
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $product->product_image) }}">
                        <p class="product-name">
                            <a href="{{ route('item.show', $product->id) }}">
                                {{ $product->product_name }}
                            </a>
                        </p>

                    </div>
                @empty
                @endforelse
            </div>
        </div>

        {{-- 購入した商品 --}}
        <div id="purchased" class="tab-content {{ $page === 'buy' ? 'active' : '' }}">
            <div class="product-list">
                @forelse ($purchasedProducts as $purchase)
                    @php
                        $product = $purchase->product;
                    @endphp
                    @if ($product)
                        <div class="product-card">
                            <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('default.jpeg') }}"
                                alt="{{ $product->product_name }}">
                            <p class="product-name">
                                <a href="{{ route('item.show', $product->id) }}">
                                    {{ $product->product_name }}
                                </a>
                            </p>
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
