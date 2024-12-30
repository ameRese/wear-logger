<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            統計情報
        </h2>
    </x-slot>
    <ul class="max-w-7xl mx-auto px-6">
        <li class="mt-4">
            <a href="{{ route('stat.unused_item') }}">未使用アイテムリスト</a>
        </li>
        <li class="mt-4">
            <a href="#">着用回数ランキング</a>
        </li>
    </ul>
</x-app-layout>
