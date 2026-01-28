@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index-container">

        {{-- タブ --}}
        <div class="tabs">
            <a href="{{ route('index') }}" class="tab {{ $tab === 'recommend' ? 'active' : '' }}">
                おすすめ
            </a>

            <a href="{{ route('index', ['tab' => 'mylist']) }}" class="tab {{ $tab === 'mylist' ? 'active' : '' }}">
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

                    <a href="{{ route('item.show', $product->id) }}">
                        <div class="image-wrapper">
                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="">

                            @if ($product->is_sold)
                                <span class="sold-label">Sold</span>
                            @endif
                        </div>

                        <p class="product-name">{{ $product->product_name }}</p>
                    </a>

                </div>
            @empty
            @endforelse
        </div>

    </div>
@endsection
