@props(['items', 'showModal' => false, 'selectedYear' => 'all'])

<div class="container mx-auto px-2 text-center">
    @if ($items->isEmpty())
        <p class="py-4">アイテムはありません。</p>
    @else
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
            </div>
            <x-text-input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="my-2 w-full pl-10" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 pb-2">
            @foreach ($items as $item)
                <!-- アイテムカード -->
                <div class="js-item relative rounded transition-all"
                    data-item-id="{{ $item->id }}"
                    data-is-weared="{{ $item->isWearedToday() ? '1' : '0' }}">
                    <div class="js-item-checkbox absolute top-2 left-2 z-10 hidden">
                        <input type="checkbox" class="h-5 w-5 rounded-md border-gray-300 text-indigo-600 focus:ring-indigo-600">
                    </div>
                    @if ($showModal)
                        <a href="#" data-modal-target="item-modal-{{ $item->id }}" class="js-item-link">
                    @endif
                        <x-item-card class="js-item-card {{ $item->isWearedToday() ? 'border-t-4 border-t-indigo-600' : '' }}"
                            :item="$item" :enableSearch="true" :selectedYear="$selectedYear" />
                    @if ($showModal)
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@if ($showModal)
    <x-slot name="modals">
        <div>
            @foreach ($items as $item)
            <!-- アイテムモーダル -->
                <dialog id="item-modal-{{ $item->id }}" class="p-2 w-full max-w-md rounded-lg">
                    <x-item-card :item="$item" />
                    <div class="mt-2 flex justify-center gap-4">
                        @if ($item->isWearedToday())
                            <form method="post" action="{{ route('wear-log.destroy', $item->getLatestWearLog()) }}">
                                @csrf
                                @method('delete')
                                <x-primary-button>今日着た！を解除</x-primary-button>
                            </form>
                        @else
                            <form method="post" action="{{ route('wear-log.store', $item) }}">
                                @csrf
                                <x-primary-button>今日着た！</x-primary-button>
                            </form>
                        @endif
                        <a href="{{ route('item.show', $item) }}">
                            <x-primary-button type="button">アイテム詳細</x-primary-button>
                        </a>
                    </div>
                </dialog>
            @endforeach
        </div>
    </x-slot>

    @vite(['resources/js/modules/search.js', 'resources/js/modules/modal.js'])
@else
    @vite('resources/js/modules/search.js')
@endif
