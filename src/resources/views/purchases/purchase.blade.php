{{-- 商品購入画面 --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-container">

        {{-- 左カラム --}}
        <div class="purchase-left">

            {{-- 商品情報 --}}
            <div class="product-box">
                <img src="{{ Storage::url($product->product_image) }}" class="product-image">

                <div class="product-info">
                    <p class="product-name">{{ $product->product_name }}</p>
                    <p class="product-price">¥{{ number_format($product->price) }}</p>
                </div>
            </div>

            <hr>

            {{-- 支払い方法 --}}
            <p class="section-title">支払い方法</p>
            <select id="paymentMethod">
                <option value="">選択してください</option>
                <option value="コンビニ払い">コンビニ払い</option>
                <option value="クレジットカード">クレジットカード</option>
            </select>

            <hr>

            {{-- 配送先 --}}
            <div class="address-box">
                <div class="address-top">
                    <p class="section-title">配送先</p>
                    <a href="{{ route('purchase.address.edit', $product->id) }}" class="change-link">
                        変更する
                    </a>
                </div>

                @if ($address)
                    <p>〒 {{ $address['post_code'] }}</p>
                    <p>{{ $address['address'] }}</p>

                    @if (!empty($address['building_name']))
                        <p>{{ $address['building_name'] }}</p>
                    @endif
                @else
                    <p>住所が未登録です</p>
                @endif

            </div>
        </div>

        {{-- 右カラム --}}
        <div class="purchase-right">
            <div class="summary-box">

                <div class="summary-section">
                    <span>商品代金</span>
                    <span>¥{{ number_format($product->price) }}</span>
                </div>

                <div class="summary-section">
                    <span>支払い方法</span>
                    <span id="paymentMethodDisplay">選択してください</span>
                </div>

            </div>

            <form method="POST" action="{{ route('purchase.store', $product->id) }}">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method_input">
                <input type="hidden" name="shipping_address" id="shipping_address_input"
                    value="{{ $address['address'] ?? '' }}">

                <button type="submit" class="purchase-button">
                    購入する
                </button>
            </form>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('paymentMethod');
            const display = document.getElementById('paymentMethodDisplay');
            const hidden = document.getElementById('payment_method_input');
            if (!select || !display || !hidden) return;
            select.addEventListener('change', () => {
                const value = select.value;
                display.textContent = value || '選択してください';
                hidden.value = value;
            });
        });
    </script>
@endsection
