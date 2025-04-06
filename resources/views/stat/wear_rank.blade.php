<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            着用回数ランキング
        </h2>
    </x-slot>
    <x-item-list :items="$wearCountSortedItems" :showModal="false" />
</x-app-layout>
