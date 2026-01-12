@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="container">

    {{-- プロフィール --}}
    <div class="profile-header">
        <img
            src="{{ Auth::user()->profile_picture
                ? asset('storage/' . Auth::user()->profile_picture)
                : asset('default.jpeg') }}"
            class="profile-image"
        >

        <h1 class="user-name">{{ Auth::user()->name }}</h1>

        <a href="{{ route('mypage.profile') }}" class="edit-profile-btn">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    <div class="tab-menu">
        <button class="tab active" data-target="selling">出品した商品</button>
        <button class="tab" data-target="purchased">購入した商品</button>
    </div>

    {{-- 出品した商品 --}}
    <div id="selling" class="tab-content active">
        <div class="product-list">
            @forelse ($sellingProducts as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->product_image) }}">
                    <p class="product-name">{{ $product->product_name }}</p>
                </div>
            @empty
                <p class="empty-text">出品した商品はありません</p>
            @endforelse
        </div>
    </div>

    {{-- 購入した商品 --}}
    {{-- <div id="purchased" class="tab-content">
        <div class="product-list">
            @forelse ($purchasedProducts ?? [] as $purchase)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $purchase->product->product_image) }}">
                    <p class="product-name">{{ $purchase->product->product_name }}</p>
                </div>
            @empty
                <p class="empty-text">購入した商品はありません</p>
            @endforelse
        </div>
    </div> --}}

</div>

{{-- JS --}}
<script>
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.target).classList.add('active');
    });
});
</script>
@endsection
