<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アイテム登録
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <form method="post" action="{{ route('item.store') }}" class="mx-auto">
            @csrf
            <img src="{{ asset('img/180x240Dummy.png') }}" alt="">
            <table>
                <tr>
                    <th><label for="item">アイテム名</label></th>
                    <td><input type="text" name="name" id="item" placeholder="必須" value="{{ old('name') }}"></td>
                </tr>
                <tr>
                    <th><label for="category">カテゴリー</label></th>
                    <td>
                        <select name="category_id" id="category">
                            <option value="">選択してください</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="color">カラー</label></th>
                    <td>
                        <select name="color_id" id="color">   
                            <option value="">選択してください</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="brand">ブランド</label></th>
                    <td>
                        <select name="brand_id" id="brand">   
                            <option value="">選択してください</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="season">シーズン</label></th>
                    <td>
                        <select name="season_id" id="season">  
                            <option value="">選択してください</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="price">購入価格</label></th>
                    <td><input type="number" name="price" id="price" placeholder="オプション"></td>
                </tr>
                <tr>
                    <th><label for="purchase-date">購入日</label></th>
                    <td><input type="date" name="purchase_date" id="purchase-date" placeholder="オプション"></td>
                </tr>
                <tr>
                    <th><label for="pre-regist-wear-count">登録前の着用日数</label></th>
                    <td><input type="number" name="pre_regist_wear_count" id="pre-regist-wear-count" placeholder="オプション"></td>
                </tr>
            </table>
            @foreach ($errors->all() as $error)
                <x-input-error :messages="$error" class="mt-2"></x-input-error>
            @endforeach
            <x-primary-button>
                登録
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
