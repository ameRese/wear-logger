@props(['item', 'enableSearch' => false])

<div class="flex">
    <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('img/no_image.png') }}"
        alt="" width="90" height="120" class="object-contain">
    <div class="py-1 ml-2 flex-1">
        <div class="pb-1">
            <div class="grid grid-cols-2 gap-1">
                <span class="{{ $enableSearch ? 'js-category' : '' }} truncate text-left">{{ $item->category->name }}</span>
                <span class="{{ $enableSearch ? 'js-brand' : '' }} truncate text-right">{{ $item->brand->name }}</span>
            </div>
        </div>
        <div class="pb-1">
            <div class="grid grid-cols-2 gap-1">
                <span class="{{ $enableSearch ? 'js-name' : '' }} truncate text-left">{{ $item->name }}</span>
                <span class="truncate text-right">{{ $item->season->name }}</span>
            </div>
        </div>
        <hr>
        <div class="pt-1">
            <dl class="grid grid-cols-2 gap-1">
                <dt class="text-left">着用日数:</dt>
                <dd class="text-right">{{ $item->getWearCount() }}</dd>
            </dl>
        </div>
        <div class="pt-1">
            <dl class="grid grid-cols-2 gap-1">
                <dt class="text-left">最終着用日:</dt>
                <dd class="text-right">{{ $item->getLatestWearLog()?->wear_date ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>
