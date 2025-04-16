<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => 'アイテム登録', 'url' => route('item.create')],
        ]" />
    </x-slot>

    <div class="px-2 py-4">
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
