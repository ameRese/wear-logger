<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-2 text-center">
        <img src="{{ asset('img/180x240Dummy.png') }}" alt="" width="180" height="240" class="mx-auto mb-1">
        <h1>{{ $item->name }}</h1>
        <table class="mx-auto">
            <tr>
                <th class="text-left">カテゴリー</th>
                <td class="pl-2 py-1">{{ $item->category->name }}</td>
            </tr>
            <tr>
                <th class="text-left">カラー</th>
                <td class="pl-2 py-1">{{ $item->color->name }}</td>
            </tr>
            <tr>
                <th class="text-left">ブランド</th>
                <td class="pl-2 py-1">{{ $item->brand->name }}</td>
            </tr>
            <tr>
                <th class="text-left">シーズン</th>
                <td class="pl-2 py-1">{{ $item->season->name }}</td>
            </tr>
            <tr>
                <th class="text-left">購入価格</th>
                <td class="pl-2 py-1">{{ $item->price }}</td>
            </tr>
            <tr>
                <th class="text-left">購入日</th>
                <td class="pl-2 py-1">{{ $item->purchase_date }}</td>
            </tr>
            <tr>
                <th class="text-left">登録前の着用日数</th>
                <td class="pl-2 py-1">{{ $item->pre_regist_wear_count }}</td>
            </tr>
        </table>
        <div class="mt-1">
            <a href="{{ route('item.edit', $item) }}">
                <x-primary-button>アイテム編集</x-primary-button>
            </a>
            <a href="#" class="js-link">
                <x-primary-button>着用日編集</x-primary-button>
            </a>
            <dialog class="js-modal max-w-full p-1">
                <form class="text-center">
                    <div class="flex justify-between">
                        <x-secondary-button id="js-previous-month">
                            前月
                        </x-secondary-button>
                        <span id="js-calendar-header"></span>
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
                        <x-primary-button id="js-update">
                            更新
                        </x-primary-button>
                        <x-primary-button type="button" class="js-cancel ml-2">
                            キャンセル
                        </x-primary-button>
                    </div>
                </form>
            </dialog>
            <a href="#" class="js-link">
                <x-primary-button class="bg-red-700">アイテムを削除</x-primary-button>
            </a>
            <dialog class="js-modal p-1">
                <div class="p-4">
                    <p class="pb-4">本当に削除してよろしいですか？</p>
                    <div class="flex justify-center">
                        <form method="post" action="{{ route('item.destroy', $item) }}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="bg-red-700">はい</x-primary-button>
                        </form>
                        <x-primary-button class="js-cancel ml-2">
                            キャンセル
                        </x-primary-button>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
</x-app-layout>
