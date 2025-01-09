<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            未使用アイテム
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-2 text-center">
        @if ($unusedItems->isEmpty())
            <p>未使用のアイテムはありません。</p>
        @else
            <input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="p-1 min-w-80">
            @foreach ($unusedItems as $unusedItem)
                <div class="js-item flex py-1">
                    <img src="{{ $unusedItem->image_path ? asset('storage/' . $unusedItem->image_path) : asset('img/no_image.png') }}"
                        alt="" width="90" height="120">
                    <div class="py-1 ml-2 min-w-[261px]">
                        <div class="pb-1">
                            <div class="flex justify-between">
                                <span class="js-category pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $unusedItem->category->name }}</span>
                                <span class="js-brand pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $unusedItem->brand->name }}</span>
                            </div>
                        </div>
                        <div class="pb-1">
                            <div class="flex justify-between">
                                <span class="js-name pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $unusedItem->name }}</span>
                                <span class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $unusedItem->season->name }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="pt-1">
                            <dl class="flex justify-between">
                                <dt class="pr-1">着用日数:</dt>
                                <dd class="pl-1">{{ $unusedItem->getWearCount() }}</dd>
                            </dl>
                        </div>
                        <div class="pt-1">
                            <dl class="flex justify-between">
                                <dt class="pr-1">最終着用日:</dt>
                                <dd class="pl-1">{{ $unusedItem->getLatestWearLog()?->wear_date ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        @endif
    </div>
    @vite('resources/js/modules/search.js')
</x-app-layout>
