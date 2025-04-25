<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => 'アイテム一覧', 'url' => route('item.index')],
        ]" />
    </x-slot>
    <div class="pb-16 relative">
        <x-message class="bottom-20 bg-indigo-600" :message="session('message')" />
        <x-item-list :items="$items" :showModal="true" />
    </div>
    <x-slot name="footer">
        <div class="fixed z-50 bottom-0 w-full bg-white">
            <hr>
            <div class="flex justify-center my-2" id="js-normal-buttons">
                <a href="{{ route('item.create') }}">
                    <x-primary-button type="button">アイテム登録</x-primary-button>
                </a>
                <x-secondary-button type="button" class="ml-4" id="js-multi-select-btn">
                    複数選択
                </x-secondary-button>
            </div>
            
            <!-- 複数選択時に表示するボタン群 -->
            <div class="hidden flex-col items-center my-2" id="js-multi-select-actions">
                <div class="flex justify-center items-center mb-2">
                    <span class="mr-2 font-bold"><span id="js-selected-count">0</span>件選択中</span>
                    <x-secondary-button type="button" id="js-cancel-selection" class="mr-2">
                        キャンセル
                    </x-secondary-button>
                </div>
                <div class="flex justify-center gap-2">
                    <x-primary-button type="button" id="js-toggle-wear-btn">
                        まとめて今日着た！
                    </x-primary-button>
                    <x-danger-button type="button" id="js-multi-delete-btn">
                        まとめて削除
                    </x-danger-button>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- 削除確認モーダル -->
    <dialog id="js-delete-confirm-modal" class="p-4 rounded-lg">
        <h3 class="text-lg font-bold mb-4">アイテムの削除</h3>
        <p>選択したアイテムを削除します。この操作は取り消せません。</p>
        <div class="flex justify-end mt-4 gap-2">
            <x-secondary-button type="button" onclick="document.getElementById('js-delete-confirm-modal').close()">
                キャンセル
            </x-secondary-button>
            <x-danger-button type="button" id="js-confirm-delete-btn">
                削除する
            </x-danger-button>
        </div>
    </dialog>

    @vite(['resources/js/modules/multi-select.js'])
</x-app-layout>
