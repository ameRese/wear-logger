@props(['items', 'showModal' => false])

<div class="max-w-2xl mx-auto px-2 text-center">
    @if ($items->isEmpty())
        <p>アイテムはありません。</p>
    @else
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <x-text-input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="my-2 w-full" />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-2">
            @foreach ($items as $item)
                <!-- アイテムカード -->
                <div class="js-item px-2 py-1 border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    @if ($showModal)
                        <a href="#" data-modal-target="item-modal-{{ $item->id }}">
                    @endif
                        <x-item-card :item="$item" :enableSearch="true" />
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
                <dialog id="item-modal-{{ $item->id }}" class="max-w-md p-4 rounded-lg shadow-lg w-full">
                    <x-item-card :item="$item" />
                    <hr class="my-2">
                    <div class="flex justify-center gap-2 mt-3">
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
            @endforeach
        </div>
    </x-slot>

    @vite(['resources/js/modules/search.js', 'resources/js/modules/modal.js'])
@else
    @vite('resources/js/modules/search.js')
@endif
