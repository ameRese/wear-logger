<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => 'アイテム一覧', 'url' => route('item.index')],
        ]" />
    </x-slot>
    <div class="pb-14">
        <x-item-list :items="$items" :showModal="true" />
    </div>
    <x-slot name="footer">
        <div class="fixed bottom-0 w-full bg-white">
            <hr>
            <div class="flex justify-center my-2">
                <a href="{{ route('item.create') }}">
                    <x-primary-button>アイテム登録</x-primary-button>
                </a>
                {{-- <x-secondary-button class="ml-4">複数選択</x-secondary-button> --}}
            </div>
        </div>
    </x-slot>
</x-app-layout>
