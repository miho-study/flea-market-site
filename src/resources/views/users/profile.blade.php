{{-- プロフィール画面 --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="title">
            <h1>ユーザー名</h1>
        </div>
        <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data">

            @csrf

            <div class="form-group" style="display:flex; align-items:center; gap:20px;">

                {{-- 表示する画像 --}}
@if(Auth::user()->profile_picture)
    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
         alt="プロフィール画像">
@else
    <img src="{{ asset('default.jpeg') }}"
         alt="デフォルト画像">
@endif


                {{-- プロフィール編集ボタン --}}
                <a href="{{ route('mypage.profile') }}" class="edit-profile-btn">
    プロフィールを編集する
</a>




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

        {{-- <div style="margin-top: 20px; text-align: center;">
            <p><a href="{{ route('/') }}">更新する</a></p>
        </div> --}}
    </div>
@endsection
