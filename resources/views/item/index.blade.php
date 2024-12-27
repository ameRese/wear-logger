<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <input type="search" placeholder="カテゴリー、ブランドなど">
        @foreach ($items as $item)
            <div class="flex p-2">
                <img src="{{ asset('img/90x120Dummy.png') }}" alt="">
                <div class="p-1">
                    <div class="p-1">
                        <div class="flex">
                            <div class="px-1">{{ $item->category->name }}</div>
                            <div class="px-1">{{ $item->brand->name }}</div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="flex">
                            <div class="px-1">{{ $item->name }}</div>
                            <div class="px-1">{{ $item->season->name }}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="p-1">
                        <dl class="flex">
                            <dt class="px-1">着用日数:</dt>
                            <dd class="px-1"></dd>
                        </dl>
                    </div>
                    <div class="p-1">
                        <dl class="flex">
                            <dt class="px-1">最終着用日:</dt>
                            <dd class="px-1"></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
    <div>
        <a href="{{ route('item.create') }}">アイテム登録</a>
        <x-secondary-button>複数選択</x-secondary-button>
    </div>
</x-app-layout>
