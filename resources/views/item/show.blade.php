<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => 'アイテム一覧', 'url' => route('item.index')],
            ['name' => $item->name, 'url' => route('item.show', $item)],
        ]" />
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto px-2">
            @if (session('message'))
                <div class="text-red-600 font-bold my-2">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-3">
                <span class="hidden" id="js-item-id">{{ $item->id }}</span>

                <div class="md:flex md:gap-8 md:items-start">
                    <!-- 左側：画像表示エリア -->
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        <div class="text-center">
                            <div class="border-2 border-gray-200 rounded-lg p-3 bg-gray-50">
                                <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                                    alt="" class="mx-auto max-h-60 object-contain">
                            </div>
                        </div>
                    </div>

                    <!-- 右側：アイテム情報表示エリア -->
                    <div class="md:w-2/3">
                        <div class="space-y-4">
                            <div>
                                <p class="text-gray-700 font-medium">アイテム名</p>
                                <div class="mt-1 p-2 border rounded-md bg-gray-50">{{ $item->name }}</div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-700 font-medium">カテゴリー</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">{{ $item->category->name }}</div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">カラー</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">{{ $item->color->name }}</div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">ブランド</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">{{ $item->brand->name }}</div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">シーズン</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">{{ $item->season->name }}</div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">購入価格</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">
                                        {{ $item->price ? '¥'.number_format($item->price) : '未設定' }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">購入日</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">
                                        {{ $item->purchase_date ?: '未設定' }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">登録前の着用日数</p>
                                    <div class="mt-1 p-2 border rounded-md bg-gray-50">
                                        {{ $item->pre_regist_wear_count ?: '0' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <div class="flex justify-center space-x-4 mb-4">
                        <a href="{{ route('item.edit', $item) }}">
                            <x-primary-button>アイテム編集</x-primary-button>
                        </a>
                        <a href="#" data-modal-target="calendar-modal">
                            <x-primary-button>着用日編集</x-primary-button>
                        </a>
                    </div>
                    <div>
                        <a href="#" data-modal-target="delete-modal">
                            <x-danger-button>アイテムを削除</x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="modals">
        <!-- カレンダーモーダル -->
        <dialog id="calendar-modal" class="max-w-full rounded-lg shadow-sm p-1">
            <div class="text-center">
                <div class="flex justify-between">
                    <x-secondary-button id="js-previous-month">
                        前月
                    </x-secondary-button>
                    <span id="js-calendar-header" class="flex items-center font-semibold"></span>
                    <x-secondary-button id="js-next-month">
                        次月
                    </x-secondary-button>
                </div>
                <div class="flex justify-center text-center">
                    <span class="flex-1 p-2">日</span>
                    <span class="flex-1 p-2">月</span>
                    <span class="flex-1 p-2">火</span>
                    <span class="flex-1 p-2">水</span>
                    <span class="flex-1 p-2">木</span>
                    <span class="flex-1 p-2">金</span>
                    <span class="flex-1 p-2">土</span>
                </div>
                <div id="js-calendar-body"></div>
                <hr>
                <div class="mt-1">
                    <x-primary-button type="button" id="js-update">
                        更新
                    </x-primary-button>
                    <x-secondary-button type="button" class="js-cancel ml-2">
                        キャンセル
                    </x-secondary-button>
                </div>
            </div>
        </dialog>
        <!-- 削除確認モーダル -->
        <dialog id="delete-modal" class="max-w-full rounded-lg shadow-sm p-4">
            <div class="text-center">
                <p class="pb-4">本当に削除してよろしいですか？</p>
                <div class="flex justify-center">
                    <form method="post" action="{{ route('item.destroy', $item) }}">
                        @csrf
                        @method('delete')
                        <x-danger-button>はい</x-danger-button>
                    </form>
                    <x-secondary-button class="js-cancel ml-2">
                        キャンセル
                    </x-secondary-button>
                </div>
            </div>
        </dialog>
    </x-slot>

    @vite(['resources/js/modules/modal.js', 'resources/js/modules/calendar.js'])
</x-app-layout>
