<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-2 text-center mb-[42px]">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="p-1 min-w-80">
        @foreach ($items as $item)
            <div class="js-item">
                <a href="#" class="js-link">
                    <div class="flex py-1">
                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                            alt="" width="90" height="120">
                        <div class="py-1 ml-2 min-w-[261px]">
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <span class="js-category pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->category->name }}</span>
                                    <span class="js-brand pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->brand->name }}</span>
                                </div>
                            </div>
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <span class="js-name pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->name }}</span>
                                    <span class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->season->name }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="pt-1">
                                <dl class="flex justify-between">
                                    <dt class="pr-1">着用日数:</dt>
                                    <dd class="pl-1">{{ $item->getWearCount() }}</dd>
                                </dl>
                            </div>
                            <div class="pt-1">
                                <dl class="flex justify-between">
                                    <dt class="pr-1">最終着用日:</dt>
                                    <dd class="pl-1">{{ $item->getLatestWearLog()?->wear_date ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </a>
                <hr>
                <dialog class="js-modal max-w-full p-1">
                    <div class="flex mb-1">
                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                            alt="" width="90" height="120">
                        <div class="py-1 ml-2 min-w-[261px]">
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <span class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->category->name }}</span>
                                    <span class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->brand->name }}</span>
                                </div>
                            </div>
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <span class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->name }}</span>
                                    <span class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->season->name }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="pt-1">
                                <dl class="flex justify-between">
                                    <dt class="pr-1">着用日数:</dt>
                                    <dd class="pl-1">{{ $item->getWearCount() }}</dd>
                                </dl>
                            </div>
                            <div class="pt-1">
                                <dl class="flex justify-between">
                                    <dt class="pr-1">最終着用日:</dt>
                                    <dd class="pl-1">{{ $item->getLatestWearLog()?->wear_date ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="flex justify-center mt-1">
                        @if ($item->isWearedToday())
                        <form method="post" action="{{ route('wear_log.destroy', $item->getLatestWearLog()) }}">
                            @csrf
                            @method('delete')
                            <x-primary-button>今日着た！を解除</x-primary-button>
                        </form>
                        @else
                            <form method="post" action="{{ route('wear_log.store', $item) }}">
                                @csrf
                                <x-primary-button>今日着た！</x-primary-button>
                            </form>
                        @endif
                        <a href="{{ route('item.show', $item) }}">
                            <x-primary-button class="ml-2">アイテム詳細</x-primary-button>
                        </a>
                    </div>
                </dialog>
            </div>
        @endforeach
    </div>
    <footer class="fixed bottom-0 w-full bg-white">
        <hr>
        <div class="flex justify-center m-1">
            <a href="{{ route('item.create') }}">
                <x-primary-button>アイテム登録</x-primary-button>
            </a>
            <x-secondary-button class="ml-2">複数選択</x-secondary-button>
        </div>
    </footer>
    @vite(['resources/js/modules/search.js', 'resources/js/modules/modal.js'])
</x-app-layout>
