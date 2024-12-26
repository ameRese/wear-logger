<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アイテム登録
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        <form action="post" class="mx-auto">
            <img src="{{ asset('img/180x240Dummy.png') }}" alt="">
            <table>
                <tr>
                    <th><label for="item">アイテム名</label></th>
                    <td><input type="text" id="item" placeholder="必須"></td>
                </tr>
                <tr>
                    <th><label for="category">カテゴリー</label></th>
                    <td>
                        <select value="" id="category">
                            <option value="">選択してください</option>
                            @foreach ($categories as $category)
                                <option value="">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="color">カラー</label></th>
                    <td>
                        <select value="" id="color">   
                            <option value="">選択してください</option>
                            @foreach ($colors as $color)
                                <option value="">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="brand">ブランド</label></th>
                    <td>
                        <select value="" id="brand">   
                            <option value="">選択してください</option>
                            @foreach ($brands as $brand)
                                <option value="">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="season">シーズン</label></th>
                    <td>
                        <select value="" id="season">  
                            <option value="">選択してください</option>
                            @foreach ($seasons as $season)
                                <option value="">{{ $season->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="price">購入価格</label></th>
                    <td><input type="text" id="price" placeholder="オプション"></td>
                </tr>
                <tr>
                    <th><label for="purchase-date">購入日</label></th>
                    <td><input type="text" id="purchase-date" placeholder="オプション"></td>
                </tr>
                <tr>
                    <th><label for="pre-regist-wear-count">登録前の着用日数</label></th>
                    <td><input type="text" id="pre-regist-wear-count" placeholder="オプション"></td>
                </tr>
            </table>

            <x-primary-button>
                登録
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
