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
                @php
                    $isOwner = auth()->id() === $product->user_id;
                @endphp

                <form action="{{ route('nice.store', $product->id) }}" method="POST" class="{{ $isOwner ? 'owner' : '' }}">
                    @csrf
                    <button type="submit" class="icon-btn vertical {{ $isLiked ? 'liked' : '' }}">
                        <svg class="heart-icon" viewBox="0 0 24 24">
                            <path
                                d="M20.8 4.6c-1.9-1.9-5-1.9-6.9 0L12 6.5l-1.9-1.9c-1.9-1.9-5-1.9-6.9 0-1.9 1.9-1.9 5 0 6.9L12 21l8.8-9.5c1.9-1.9 1.9-5 0-6.9z" />
                        </svg>
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
                        @endforelse
                    </div>
                </div>


                <div class="category-row">
                    <p class="label">商品の状態</p>
                    <span class="product-condition-tags">
                        {{ $product->product_condition ?? '未設定' }}
                    </span>
                </div>


                {{-- コメント --}}
                <div class="section">
                    <h2>コメント({{ $product->comments_count }})</h2>
                    <div class="comment-list">
                        @forelse ($product->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <img src="{{ $comment->user->profile_picture
                                        ? asset('storage/' . $comment->user->profile_picture)
                                        : asset('default.jpeg') }}"
                                        class="comment-icon" alt="ユーザーアイコン">
                                    <strong>{{ $comment->user->name }}</strong>
                                </div>

                                <div class="comment-body">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>

                    @error('comment')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>
                <h2>商品へのコメント</h2>

                {{-- コメント投稿フォーム --}}
                <form method="POST" action="{{ route('comments.store', $product->id) }}">
                    @csrf

                    <textarea name="comment" required></textarea>

                    <button type="submit" class="comment-button">
                        コメントを送信する
                    </button>
                </form>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const niceForm = document.querySelector('form[action*="/nice"]');
            if (!niceForm) return;

            niceForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const btn = niceForm.querySelector('button');
                const countSpan = btn.querySelector('span');
                const formData = new FormData(niceForm);
                const action = niceForm.action;
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrf = tokenMeta ? tokenMeta.getAttribute('content') : (niceForm.querySelector(
                    'input[name="_token"]') || {}).value;

                try {
                    const res = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: formData,
                        credentials: 'same-origin'
                    });

                    if (res.ok) {
                        const likedNow = btn.classList.toggle('liked');
                        if (countSpan) {
                            const n = parseInt(countSpan.textContent || '0', 10);
                            countSpan.textContent = likedNow ? n + 1 : Math.max(0, n - 1);
                        }
                    } else {
                        niceForm.submit();
                    }
                } catch (err) {
                    niceForm.submit();
                }
            });
        });
    </script>
@endsection
