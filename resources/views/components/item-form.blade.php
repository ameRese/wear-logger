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
                    <label>
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
                        <x-input-label for="item">
                            アイテム名 <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input type="text" name="name" id="item" placeholder="必須" 
                            class="block mt-1 w-full" value="{{ old('name', $item?->name) }}" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category">
                                カテゴリー <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-select-menu
                                name="category_id"
                                id="category"
                                class="mt-1 w-full"
                                :options="$categories"
                                :selected="$item?->category->id"
                            />
                        </div>
                        <div>
                            <x-input-label for="color">
                                カラー <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-select-menu
                                name="color_id"
                                id="color"
                                class="mt-1 w-full"
                                :options="$colors"
                                :selected="$item?->color->id"
                            />
                        </div>
                        <div>
                            <x-input-label for="brand">
                                ブランド <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-select-menu
                                name="brand_id"
                                id="brand"
                                class="mt-1 w-full"
                                :options="$brands"
                                :selected="$item?->brand->id"
                            />
                        </div>
                        <div>
                            <x-input-label for="season">
                                シーズン <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-select-menu
                                name="season_id"
                                id="season"
                                class="mt-1 w-full"
                                :options="$seasons"
                                :selected="$item?->season->id"
                            />
                        </div>
                        <div>
                            <x-input-label for="price" value="購入価格" />
                            <x-text-input type="number" name="price" id="price" placeholder="オプション" 
                                class="block mt-1 w-full" value="{{ old('price', $item?->price) }}" />
                        </div>
                        <div>
                            <x-input-label for="purchase-date" value="購入日" />
                            <x-text-input type="date" name="purchase_date" id="purchase-date" placeholder="オプション" 
                                class="block mt-1 w-full" value="{{ old('purchase_date', $item?->purchase_date) }}" />
                        </div>
                        <div>
                            <x-input-label for="pre-regist-wear-count" value="登録前の着用日数" />
                            <x-text-input type="number" name="pre_regist_wear_count" id="pre-regist-wear-count" placeholder="オプション" 
                                class="block mt-1 w-full" value="{{ old('pre_regist_wear_count', $item?->pre_regist_wear_count) }}" />
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
