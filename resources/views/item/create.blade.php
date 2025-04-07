<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アイテム登録
        </h2>
    </x-slot>

    <div class="py-4">
        <x-item-form
            :categories="$categories"
            :colors="$colors"
            :brands="$brands"
            :seasons="$seasons"
            buttonText="登録"
            :route="route('item.store')"
        />
    </div>
</x-app-layout>
