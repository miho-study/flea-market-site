{{-- 商品詳細画面 --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="product-detail">

        {{-- 左：商品画像 --}}
        <div class="product-image">
            @if ($product->product_image)
                <img src="{{ Storage::url($product->product_image) }}" alt="商品画像">
            @else
                <img src="{{ asset('default.jpeg') }}" alt="商品画像">
            @endif
        </div>

        {{-- 右：商品情報 --}}
        <div class="product-info">

            <h1 class="product-name">{{ $product->product_name }}</h1>

            <p class="brand-name">{{ $product->brand_name ?? 'ブランド名' }}</p>

            <p class="price">¥{{ number_format($product->price) }} <span>(税込)</span></p>

            {{-- いいね・コメント数 --}}
            <div class="icons">
    <form action="{{ route('nice.store', $product->id) }}" method="POST">
        @csrf
<button type="submit" class="icon-btn vertical">
    <img src="{{ asset('images/heart.png') }}" alt="like">
    <span>{{ $product->nices->count() }}</span>
</button>
    </form>

<div class="icon-btn vertical">
    <img src="{{ asset('images/comment.png') }}" alt="comment">
    <span>{{ $product->comments->count() }}</span>
</div>

</div>

            <a href="{{ route('purchase.confirm', $product->id) }}" class="buy-button">
    購入手続きへ
</a>


            {{-- 商品説明 --}}
            <div class="section">
                <h2>商品説明</h2>
                <p>{{ $product->product_description }}</p>
            </div>

            {{-- 商品情報 --}}
            <div class="section">
                <h2>商品の情報</h2>
<div class="category-row">
    <p class="label">カテゴリー</p>
    <div class="category-tags">
        @forelse ($product->categories as $category)
            <span class="tag">{{ $category->category_name }}</span>
        @empty
            <span class="tag gray">未設定</span>
        @endforelse
    </div>
</div>


<p class="product-condition">
    商品の状態
    <span>{{ $product->product_condition ?? '未設定' }}</span>
</p>


{{-- コメント --}}
<div class="section">
        <h2>コメント({{ $product->comments_count }})</h2>
        <div class="comment-list">
        @forelse ($product->comments as $comment)
<div class="comment-item">
<div class="comment-header">
    <img
        src="{{ $comment->user->profile_picture
            ? asset('storage/' . $comment->user->profile_picture)
            : asset('default.jpeg') }}"
        class="comment-icon"
        alt="ユーザーアイコン"
    >
    <strong>{{ $comment->user->name }}</strong>
</div>

    <p>{{ $comment->comment }}</p>
</div>

        @empty
            <p>まだコメントはありません</p>
        @endforelse
    </div>
    <h2>商品へのコメント</h2>

    {{-- コメント投稿フォーム --}}
    <form method="POST" action="{{ route('comments.store', $product->id) }}">
        @csrf

        <textarea
            name="comment"
            required
        ></textarea>

        <button type="submit" class="comment-button">
            コメントを送信する
        </button>
    </form>
</div>


        </div>
    </div>
@endsection
