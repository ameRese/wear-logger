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
        <a href="{{ route('item.edit', $item) }}">
            <x-primary-button>アイテム編集</x-primary-button>
        </a>
        <x-primary-button>着用日編集</x-primary-button>
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
    <script src="{{ asset('js/modal.js') }}"></script>
</x-app-layout>
