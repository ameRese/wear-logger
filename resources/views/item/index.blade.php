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
        <input type="search" placeholder="カテゴリー、ブランドなど" class="p-1 min-w-80">
        @foreach ($items as $item)
            <div>
                <a href="#" class="js-item">
                    <div class="flex py-1">
                        <img src="{{ asset('img/90x120Dummy.png') }}" alt="" width="90" height="120">
                        <div class="py-1 ml-2 min-w-[261px]">
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <div class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->category->name }}</div>
                                    <div class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->brand->name }}</div>
                                </div>
                            </div>
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <div class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->name }}</div>
                                    <div class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->season->name }}</div>
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
                        <img src="{{ asset('img/90x120Dummy.png') }}" alt="" width="90" height="120">
                        <div class="py-1 ml-2 min-w-[261px]">
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <div class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->category->name }}</div>
                                    <div class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->brand->name }}</div>
                                </div>
                            </div>
                            <div class="pb-1">
                                <div class="flex justify-between">
                                    <div class="pr-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->name }}</div>
                                    <div class="pl-1 overflow-hidden whitespace-nowrap text-ellipsis">{{ $item->season->name }}</div>
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
    <script src="{{ asset('js/modal.js') }}"></script>
</x-app-layout>
