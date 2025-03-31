@props(['items', 'showModal' => false])

@if ($items->isEmpty())
    <p>アイテムはありません。</p>
@else
    <input type="search" placeholder="名称、カテゴリー、ブランドで絞り込み" id="js-search" class="m-2 p-1 min-w-80">
    @foreach ($items as $item)
        <div class="js-item">
            @if ($showModal)
                <a href="#" class="js-link">
            @endif
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
            @if ($showModal)
                </a>
            @endif
            <hr>

            @if ($showModal)
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
            @endif
        </div>
    @endforeach
@endif

@if ($showModal)
    @vite(['resources/js/modules/search.js', 'resources/js/modules/modal.js'])
@else
    @vite('resources/js/modules/search.js')
@endif
