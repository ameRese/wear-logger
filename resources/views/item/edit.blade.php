<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アイテム編集
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-2">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
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
