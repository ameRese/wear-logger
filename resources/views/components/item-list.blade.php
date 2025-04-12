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
        <input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="border rounded-lg m-2 p-1 min-w-80">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-2">
            @foreach ($items as $item)
                <div class="js-item border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    @if ($showModal)
                        <a href="#" data-modal-target="item-modal-{{ $item->id }}">
                    @endif
                        <div class="flex px-2 py-1">
                            <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                                alt="" width="90" height="120" class="object-contain">
                            <div class="py-1 ml-2 flex-1">
                                <div class="pb-1">
                                    <div class="grid grid-cols-2 gap-1">
                                        <span class="js-category truncate text-left">{{ $item->category->name }}</span>
                                        <span class="js-brand truncate text-right">{{ $item->brand->name }}</span>
                                    </div>
                                </div>
                                <div class="pb-1">
                                    <div class="grid grid-cols-2 gap-1">
                                        <span class="js-name truncate text-left">{{ $item->name }}</span>
                                        <span class="pl-1 truncate text-right">{{ $item->season->name }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="pt-1">
                                    <dl class="grid grid-cols-2 gap-1">
                                        <dt class="text-left">着用日数:</dt>
                                        <dd class="text-right">{{ $item->getWearCount() }}</dd>
                                    </dl>
                                </div>
                                <div class="pt-1">
                                    <dl class="grid grid-cols-2 gap-1">
                                        <dt class="text-left">最終着用日:</dt>
                                        <dd class="text-right">{{ $item->getLatestWearLog()?->wear_date ?? '-' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
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
                    <div class="flex mb-3">
                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                            alt="" width="90" height="120" class="object-contain">
                        <div class="py-1 ml-3 flex-1">
                            <div class="pb-1">
                                <div class="grid grid-cols-2 gap-1">
                                    <span class="truncate text-left">{{ $item->category->name }}</span>
                                    <span class="truncate text-right">{{ $item->brand->name }}</span>
                                </div>
                            </div>
                            <div class="pb-1">
                                <div class="grid grid-cols-2 gap-1">
                                    <span class="truncate text-left">{{ $item->name }}</span>
                                    <span class="truncate text-right">{{ $item->season->name }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="pt-1">
                                <dl class="grid grid-cols-2 gap-1">
                                    <dt class="text-left">着用日数:</dt>
                                    <dd class="text-right">{{ $item->getWearCount() }}</dd>
                                </dl>
                            </div>
                            <div class="pt-1">
                                <dl class="grid grid-cols-2 gap-1">
                                    <dt class="text-left">最終着用日:</dt>
                                    <dd class="text-right">{{ $item->getLatestWearLog()?->wear_date ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
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
