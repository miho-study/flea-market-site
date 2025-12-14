@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
{{-- <div class="container mx-auto px-4">
  <div x-data="{ activeTab: 'recommend' }">

    <!-- タブボタン -->
    <div class="flex border-b border-gray-300 mb-6">
      <button
          x-on:click="activeTab = 'recommend'"
          :class="activeTab === 'recommend' 
              ? 'text-black border-black' 
              : 'text-gray-400 border-transparent'"
          class="w-full text-center font-bold text-lg py-2 border-b-4 transition-all"
      >
        おすすめ
      </button>

      <button
          x-on:click="activeTab = 'mylist'"
          :class="activeTab === 'mylist' 
              ? 'text-black border-black' 
              : 'text-gray-400 border-transparent'"
          class="w-full text-center font-bold text-lg py-2 border-b-4 transition-all"
      >
        マイリスト
      </button>
    </div>

    <!-- おすすめ -->
    <div x-show="activeTab === 'recommend'" class="product-list flex justify-center flex-wrap gap-8">
        @foreach ($recommend as $item)
        <div class="product-card w-[180px] text-center">
          <div class="product-image w-full aspect-square bg-gray-300 flex items-center justify-center rounded-lg mb-2 overflow-hidden">
            @if ($item->image_path)
              <img src="{{ asset('storage/' . $item->image_path) }}"
                   alt="" class="w-full h-full object-cover">
            @endif
          </div>
          <p class="product-name text-sm text-gray-700">{{ $item->name }}</p>
        </div>
        @endforeach
    </div>

    <!-- マイリスト -->
    <div x-show="activeTab === 'mylist'" class="product-list flex justify-center flex-wrap gap-8">
        @foreach ($mylist as $item)
        <div class="product-card w-[180px] text-center">
          <div class="product-image w-full aspect-square bg-gray-300 flex items-center justify-center rounded-lg mb-2 overflow-hidden">
            @if ($item->image_path)
              <img src="{{ asset('storage/' . $item->image_path) }}"
                   alt="" class="w-full h-full object-cover">
            @endif
          </div>
          <p class="product-name text-sm text-gray-700">{{ $item->name }}</p>
        </div>
        @endforeach
    </div>

  </div>
</div> --}}

    {{-- <div class="tab-container">
        <button class="tab-btn active" data-target="recommend-list">おすすめ</button>
        <button class="tab-btn" data-target="mylist-list">マイリスト</button>
    </div>

   <!-- おすすめ -->
<div class="tab-content active" id="recommend-list">
    @foreach ($recommend as $item)
        <div class="product-card">
            <div class="product-image">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}">
                @endif
            </div>
            <div class="product-name">{{ $item->name }}</div>
        </div>
    @endforeach
</div>

<!-- マイリスト -->
<div class="tab-content" id="mylist-list">
    @foreach ($mylist as $item)
        <div class="product-card">
            <div class="product-image">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}">
                @endif
            </div>
            <div class="product-name">{{ $item->name }}</div>
        </div>
    @endforeach
</div>

</div>
@endsection

@section('scripts') --}}
{{-- <script>

document.addEventListener("DOMContentLoaded", () => {
    const recommendTab = document.getElementById("recommend-tab");
    const mylistTab = document.getElementById("mylist-tab");

    const recommendList = document.getElementById("recommend-list");
    const mylistList = document.getElementById("mylist-list");

    if (!recommendTab || !mylistTab) {
        console.error("❌ タブのIDが見つかりません");
        return;
    }

    recommendTab.addEventListener("click", () => {
        recommendTab.classList.add("active");
        mylistTab.classList.remove("active");
        recommendList.classList.add("active");
        mylistList.classList.remove("active");
    });

    mylistTab.addEventListener("click", () => {
        mylistTab.classList.add("active");
        recommendTab.classList.remove("active");
        mylistList.classList.add("active");
        recommendList.classList.remove("active");
    });
});

</script>
@endsection --}}
