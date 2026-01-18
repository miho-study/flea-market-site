@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="index-container">

    {{-- タブ --}}
    <div class="tabs">
        <a href="{{ route('index', ['tab' => 'recommend']) }}"
           class="tab {{ $tab === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>

        <a href="{{ route('index', ['tab' => 'mylist']) }}"
           class="tab {{ $tab === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>

    {{-- 商品一覧 --}}
    <div class="product-grid">
        @php
            $products = $tab === 'recommend' ? $recommendProducts : $myListProducts;
        @endphp

        @forelse ($products as $product)
            <div class="product-card {{ $product->is_sold ? 'sold' : '' }}">

                @if ($product->is_sold)
                    {{-- 売り切れ：リンクなし --}}
                    <div class="image-wrapper">
                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="">
                        <span class="sold-label">SOLD</span>
                    </div>
                    <p class="product-name">{{ $product->product_name }}</p>
                @else
                    {{-- 通常商品 --}}
                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="image-wrapper">
                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="">
                        </div>
                        <p class="product-name">{{ $product->product_name }}</p>
                    </a>
                @endif

            </div>
        @empty
            <p class="empty-text">
                {{ $tab === 'recommend' ? '商品がありません' : 'マイリストは空です' }}
            </p>
        @endforelse
    </div>

</div>
@endsection
