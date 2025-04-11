<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center text-sm">
            <span>アイテム登録</span>
        </div>
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
