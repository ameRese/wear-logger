@props(['item' => null, 'categories', 'colors', 'brands', 'seasons', 'buttonText', 'route', 'method' => 'post'])

<div class="max-w-2xl mx-auto px-2">
    @if (session('message'))
        <div class="text-red-600 font-bold my-2">
            {{ session('message') }}
        </div>
    @endif

    <form method="post" action="{{ $route }}" class="mx-auto p-3 bg-white rounded-lg shadow-sm" enctype="multipart/form-data">
        @csrf
        @if($method === 'patch')
            @method('patch')
        @endif

        <div class="md:flex md:gap-8 md:items-start">
            <!-- 画像アップロードエリア -->
            <div class="md:w-1/3 mb-4 md:mb-0">
                <div class="text-center">
                    <label class="block text-gray-700 font-medium">
                        アイテム画像
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:bg-gray-50 transition cursor-pointer">
                            <img src="{{ $item?->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
                                alt="" class="mx-auto mb-2 max-h-60 object-contain" id="preview-image">
                            <p class="text-sm text-gray-500">クリックして画像をアップロード</p>
                            <input type="file" name="image" class="hidden" accept="image/png, image/jpeg">
                        </div>
                    </label>
                </div>
            </div>

            <!-- アイテム情報入力エリア -->
            <div class="md:w-2/3">
                <div class="space-y-4">
                    <div>
                        <label for="item" class="block text-gray-700 font-medium mb-1">アイテム名 <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="item" placeholder="必須" 
                            class="w-full p-2 border rounded-md" value="{{ old('name', $item?->name) }}">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-gray-700 font-medium mb-1">カテゴリー <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category" class="w-full p-2 border rounded-md">
                                <option value="">選択してください</option>
                                @if($item)
                                    <option value="{{ $item->category->id }}" selected>{{ $item->category->name }}</option>
                                @endif
                                @foreach ($categories as $category)
                                    @if(!$item || $item->category->id !== $category->id)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="color" class="block text-gray-700 font-medium mb-1">カラー <span class="text-red-500">*</span></label>
                            <select name="color_id" id="color" class="w-full p-2 border rounded-md">   
                                <option value="">選択してください</option>
                                @if($item)
                                    <option value="{{ $item->color->id }}" selected>{{ $item->color->name }}</option>
                                @endif
                                @foreach ($colors as $color)
                                    @if(!$item || $item->color->id !== $color->id)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="brand" class="block text-gray-700 font-medium mb-1">ブランド <span class="text-red-500">*</span></label>
                            <select name="brand_id" id="brand" class="w-full p-2 border rounded-md">   
                                <option value="">選択してください</option>
                                @if($item)
                                    <option value="{{ $item->brand->id }}" selected>{{ $item->brand->name }}</option>
                                @endif
                                @foreach ($brands as $brand)
                                    @if(!$item || $item->brand->id !== $brand->id)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="season" class="block text-gray-700 font-medium mb-1">シーズン <span class="text-red-500">*</span></label>
                            <select name="season_id" id="season" class="w-full p-2 border rounded-md">  
                                <option value="">選択してください</option>
                                @if($item)
                                    <option value="{{ $item->season->id }}" selected>{{ $item->season->name }}</option>
                                @endif
                                @foreach ($seasons as $season)
                                    @if(!$item || $item->season->id !== $season->id)
                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-gray-700 font-medium mb-1">購入価格</label>
                            <input type="number" name="price" id="price" placeholder="オプション" 
                                class="w-full p-2 border rounded-md" value="{{ old('price', $item?->price) }}">
                        </div>
                        <div>
                            <label for="purchase-date" class="block text-gray-700 font-medium mb-1">購入日</label>
                            <input type="date" name="purchase_date" id="purchase-date" placeholder="オプション" 
                                class="w-full p-2 border rounded-md" value="{{ old('purchase_date', $item?->purchase_date) }}">
                        </div>
                        <div>
                            <label for="pre-regist-wear-count" class="block text-gray-700 font-medium mb-1">登録前の着用日数</label>
                            <input type="number" name="pre_regist_wear_count" id="pre-regist-wear-count" placeholder="オプション" 
                                class="w-full p-2 border rounded-md" value="{{ old('pre_regist_wear_count', $item?->pre_regist_wear_count) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($errors->all() as $error)
            <x-input-error :messages="$error" class="mt-2"></x-input-error>
        @endforeach

        <div class="mt-6 text-center">
            <x-primary-button class="px-6 py-2">
                {{ $buttonText }}
            </x-primary-button>
        </div>
    </form>
</div>
