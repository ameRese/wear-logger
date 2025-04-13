<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => '統計情報', 'url' => route('stat.index')],
            ['name' => '未使用アイテムリスト', 'url' => route('stat.unused_item')],
        ]" />
    </x-slot>
    <x-item-list :items="$unusedItems" :showModal="false" />
</x-app-layout>
