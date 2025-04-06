<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アイテム編集
        </h2>
    </x-slot>
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
</x-app-layout>
