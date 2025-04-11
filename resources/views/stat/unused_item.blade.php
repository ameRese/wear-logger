<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center text-sm">
            <a href="{{ route('stat.index') }}" class="whitespace-nowrap">統計情報</a>
            <span class="mx-2">/</span>
            <span class="truncate">未使用アイテムリスト</span>
        </div>
    </x-slot>
    <x-item-list :items="$unusedItems" :showModal="false" />
</x-app-layout>
