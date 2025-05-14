@props(['item', 'enableSearch' => false, 'selectedYear' => 'all'])

<div {{ $attributes->merge(['class' => 'flex bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden']) }}>
    <div class="w-1/3 relative">
        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
            alt="{{ $item->name }}の画像" class="absolute inset-0 w-full h-full object-cover">
    </div>
    <div class="w-2/3 p-2 flex flex-col">
        <div class="mb-1">
            <div class="grid grid-cols-2">
                <span class="{{ $enableSearch ? 'js-name' : '' }} font-bold truncate text-left">{{ $item->name }}</span>
                <span class="{{ $enableSearch ? 'js-category' : '' }} truncate text-right">{{ $item->category->name }}</span>
            </div>
        </div>
        <div class="mb-1">
            <div class="grid grid-cols-2">
                <span class="{{ $enableSearch ? 'js-brand' : '' }} truncate text-left">{{ $item->brand->name }}</span>
                <span class="truncate text-right">{{ $item->season->name }}</span>
            </div>
        </div>
        <hr class="my-1">
        <div class="mt-1">
            <dl class="grid grid-cols-2">
                <dt class="text-left">着用日数:</dt>
                <dd class="text-right">{{ $item->getWearCount($selectedYear) }}</dd>
            </dl>
        </div>
        <div class="mt-1">
            <dl class="grid grid-cols-2">
                <dt class="text-left">最終着用日:</dt>
                <dd class="text-right">{{ $item->getLatestWearLog()?->wear_date->format('Y-m-d') ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>
