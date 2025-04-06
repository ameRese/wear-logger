<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            未使用アイテム
        </h2>
    </x-slot>
    <x-item-list :items="$unusedItems" :showModal="false" />
</x-app-layout>
