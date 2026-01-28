{{-- プロフィール編集画面 --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="title">
            <h1>プロフィール設定</h1>
        </div>

        <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data">

            @csrf

            <div class="form-group" style="display:flex; align-items:center; gap:20px;">

                {{-- 表示する画像 --}}
                @if ($user->profile_picture === null)
                    <img class="rounded-circle" src="{{ asset('default.jpeg') }}" alt="プロフィール画像" width="100"
                        height="100">
                @else
                    <img class="rounded-circle" src="{{ Storage::url($user->profile_picture) }}" alt="プロフィール画像"
                        width="100" height="100">
                @endif

                {{-- 画像変更ボタン --}}
                <button type="button" id="change_image_btn" class="image_change_btn">
                    画像を変更する
                </button>

                {{-- 非表示の file input --}}
                <input id="profile_picture" name="profile_picture" type="file" accept="image/png, image/jpeg"
                    style="display:none;">

                @error('profile_picture')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <script>
                const changeImageBtn = document.getElementById('change_image_btn');
                const profilePictureInput = document.getElementById('profile_picture');

                changeImageBtn.addEventListener('click', function() {
                    profilePictureInput.click();
                });
                profilePictureInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const imgElement = document.querySelector('.rounded-circle');
                            if (imgElement) {
                                imgElement.src = event.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>


            {{-- ユーザー名 --}}
            <div class="form-group">
                <label for="name" class="item-title">ユーザー名</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus>

                {{-- 個別エラー --}}
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 郵便番号 --}}
            <div class="form-group">
                <label for="post_code" class="item-title">郵便番号</label>
                <input id="post_code" type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}">

                @error('post_code')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 住所 --}}
            <div class="form-group">
                <label for="address" class="item-title">住所</label>
                <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}">

                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 建物名 --}}
            <div class="form-group">
                <label for="building_name" class="item-title">建物名</label>
                <input id="building_name" type="text" name="building_name"
                    value="{{ old('building_name', $user->building_name) }}">

                @error('building_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="update_btn">更新する</button>
        </form>
    </div>
@endsection
