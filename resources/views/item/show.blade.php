<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <img src="{{ asset('img/180x240Dummy.png') }}" alt="">
        <h1>{{ $item->name }}</h1>
        <table>
            <tr>
                <th>カテゴリー</th>
                <td>{{ $item->category->name }}</td>
            </tr>
            <tr>
                <th>カラー</th>
                <td>{{ $item->color->name }}</td>
            </tr>
            <tr>
                <th>ブランド</th>
                <td>{{ $item->brand->name }}</td>
            </tr>
            <tr>
                <th>シーズン</th>
                <td>{{ $item->season->name }}</td>
            </tr>
            <tr>
                <th>購入価格</th>
                <td>{{ $item->price }}</td>
            </tr>
            <tr>
                <th>購入日</th>
                <td>{{ $item->purchase_date }}</td>
            </tr>
            <tr>
                <th>登録前の着用日数</th>
                <td>{{ $item->pre_regist_wear_count }}</td>
            </tr>
        </table>
        <x-secondary-button>着用日編集</x-secondary-button>
        <form method="post" action="{{ route('item.destroy', $item) }}">
            @csrf
            @method('delete')
            <x-primary-button>アイテムを削除</x-primary-button>
        </form>
    </div>
</x-app-layout>
