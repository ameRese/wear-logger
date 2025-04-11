<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center text-sm">
            <a href="{{ route('item.index') }}" class="whitespace-nowrap">アイテム一覧</a>
            <span class="mx-2">/</span>
            <a href="{{ route('item.show', $item) }}" class="truncate">{{ $item->name }}</a>
            <span class="mx-2">/</span>
            <span class="whitespace-nowrap">編集</span>
        </div>
    </x-slot>

    <div class="py-4">
        <x-item-form
            :item="$item"
            :categories="$categories"
            :colors="$colors"
            :brands="$brands"
            :seasons="$seasons"
            buttonText="更新"
            :route="route('item.update', $item)"
            method="patch"
        />
    </div>
</x-app-layout>
