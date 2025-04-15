@props(['items', 'showModal' => false])

<div class="container mx-auto px-2 text-center">
    @if ($items->isEmpty())
        <p class="py-4">アイテムはありません。</p>
    @else
        <x-text-input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="my-2 w-full" />
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 pb-2">
            @foreach ($items as $item)
                <!-- アイテムカード -->
                <div class="js-item">
                    @if ($showModal)
                        <a href="#" data-modal-target="item-modal-{{ $item->id }}">
                    @endif
                        <x-item-card class="{{ $item->isWearedToday() ? 'border-t-4 border-t-indigo-600' : '' }}"
                            :item="$item" :enableSearch="true" />
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
                            <x-primary-button>アイテム詳細</x-primary-button>
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
