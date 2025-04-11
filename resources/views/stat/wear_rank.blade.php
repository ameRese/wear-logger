<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center text-sm">
            <a href="{{ route('stat.index') }}" class="whitespace-nowrap">統計情報</a>
            <span class="mx-2">/</span>
            <span class="truncate">着用回数ランキング</span>
        </div>
    </x-slot>
    <x-item-list :items="$wearCountSortedItems" :showModal="false" />
</x-app-layout>
