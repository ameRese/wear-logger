<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => 'アイテム一覧', 'url' => route('item.index')],
            ['name' => $item->name, 'url' => route('item.show', $item)],
            ['name' => '編集', 'url' => route('item.edit', $item)],
        ]" />
    </x-slot>

    <div class="px-2 py-4">
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
