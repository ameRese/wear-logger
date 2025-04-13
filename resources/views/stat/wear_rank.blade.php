<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => '統計情報', 'url' => route('stat.index')],
            ['name' => '着用回数ランキング', 'url' => route('stat.wear_rank')],
        ]" />
    </x-slot>
    <x-item-list :items="$wearCountSortedItems" :showModal="false" />
</x-app-layout>
