@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')
    <div class="container">

        <div class="title">
            <h1>商品の出品</h1>
        </div>
        <form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- 商品画像 --}}
            <div class="form-group">
                <label>商品画像</label>

                <div class="image-box">
                    {{-- プレビュー画像 --}}
                    <img id="preview-image" src="" alt="商品画像プレビュー"
                        style="display:none; max-width:100%; max-height:100%; object-fit:contain;">

                    {{-- 画像選択ボタン --}}
                    <label for="product_image" class="image_change_btn">
                        画像を選択する
                    </label>

                    <input id="product_image" name="product_image" type="file" accept="image/png, image/jpeg" hidden>
                </div>

                @error('product_image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- プレビュー用JS --}}
            <script>
                const productImageInput = document.getElementById('product_image');
                const previewImage = document.getElementById('preview-image');
                const imageBox = document.querySelector('.image-box');
                const imageButton = document.querySelector('.image_change_btn');

                productImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                        imageButton.style.display = 'none';
                        imageBox.style.justifyContent = 'center';
                        imageBox.style.alignItems = 'center';
                    };
                    reader.readAsDataURL(file);
                });
            </script>


            <h2>商品の詳細</h2>

            {{-- カテゴリー --}}
            <div class="form-group">
                <label class='category-title'>カテゴリー</label>

                <div class="category-buttons">
                    @foreach ($categories as $category)
                        <label class="category-item">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}">
                            <span>{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </div>



                @error('category_ids')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 商品の状態 --}}
            <div class="form-group">
                <label class='category-condition'>商品の状態</label>
                <div class="select-wrapper">

                    <select name="product_condition">
                        <option value="">選択してください</option>
                        <option value="良好">良好</option>
                        <option value="目立った傷なし">目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                        <option value="状態が悪い">状態が悪い</option>
                    </select>
                </div>
                @error('product_condition')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <h2>商品名と説明</h2>

            <div class="form-group">
                <label>商品名</label>
                <input type="text" name="product_name" value="{{ old('product_name') }}">
                @error('product_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>ブランド名</label>
                <input type="text" name="brand_name" value="{{ old('brand_name') }}">
            </div>

            <div class="form-group">
                <label class="product_description">商品の説明</label>
                <textarea name="product_description">{{ old('product_description') }}</textarea>
                @error('product_description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label class="sell-price">販売価格</label>

                <div class="price-input">
                    <span class="yen">¥</span>
                    <input type="text" name="price" value="{{ old('price') }}">
                </div>
                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">出品する</button>
        </form>
    </div>
@endsection
