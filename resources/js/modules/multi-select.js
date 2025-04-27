import { bulkToggleWear, bulkDeleteItems } from './http-request';

document.addEventListener('DOMContentLoaded', function () {
    const multiSelectBtn = document.getElementById('js-multi-select-btn');
    const cancelSelectionBtn = document.getElementById('js-cancel-selection');
    const normalButtons = document.getElementById('js-normal-buttons');
    const multiSelectActions = document.getElementById('js-multi-select-actions');
    const selectedCountElement = document.getElementById('js-selected-count');
    const itemLinks = document.querySelectorAll('.js-item-link');
    const itemCards = document.querySelectorAll('.js-item');
    const itemCheckboxes = document.querySelectorAll('.js-item-checkbox');

    // 「まとめて」操作ボタン
    const toggleWearBtn = document.getElementById('js-toggle-wear-btn');
    const multiDeleteBtn = document.getElementById('js-multi-delete-btn');
    const confirmDeleteBtn = document.getElementById('js-confirm-delete-btn');
    const deleteConfirmModal = document.getElementById('js-delete-confirm-modal');

    // 複数選択モード状態
    let isMultiSelectMode = false;
    // 選択されたアイテムのIDを保持する配列
    const selectedItemIds = new Set();

    // 複数選択モードの切り替え
    function toggleMultiSelectMode(enabled) {
        isMultiSelectMode = enabled;
        // モーダル制御用の状態も更新
        if (window.modalState) {
            window.modalState.isMultiSelectMode = enabled;
        }

        if (enabled) {
            // UI表示の切り替え
            normalButtons.classList.add('hidden');
            multiSelectActions.classList.remove('hidden');
            multiSelectActions.classList.add('flex');
            // リンクを無効化
            itemLinks.forEach((link) => {
                if (link.getAttribute('href')) {
                    // 元のリンクを保存して無効化
                    link.dataset.originalHref = link.getAttribute('href');
                    link.removeAttribute('href');
                }
            });
            // アイテムカードを選択可能に変更
            itemCards.forEach((card) => {
                card.classList.add('cursor-pointer');
                card.dataset.selectable = 'true';
            });
            // チェックボックスを表示
            itemCheckboxes.forEach((checkbox) => {
                checkbox.classList.remove('hidden');
            });
        } else {
            // UI表示の切り替え
            normalButtons.classList.remove('hidden');
            multiSelectActions.classList.add('hidden');
            multiSelectActions.classList.remove('flex');
            // リンクを再有効化
            itemLinks.forEach((link) => {
                if (link.dataset.originalHref) {
                    link.setAttribute('href', link.dataset.originalHref);
                }
            });
            // アイテムカードを選択不可に変更
            itemCards.forEach((card) => {
                card.classList.remove('cursor-pointer');
                card.dataset.selectable = 'false';
            });
            // チェックボックスを非表示
            itemCheckboxes.forEach((checkbox) => {
                checkbox.classList.add('hidden');
                const cb = checkbox.querySelector('input[type="checkbox"]');
                if (cb) {
                    cb.checked = false;
                }
            });
            // 選択状態をリセット
            selectedItemIds.clear();
            updateSelectedCount();
        }
    }

    // アイテムの選択状態を切り替える
    function toggleItemSelection(itemCard) {
        const itemId = itemCard.dataset.itemId;
        const checkbox = itemCard.querySelector('.js-item-checkbox input[type="checkbox"]');

        if (selectedItemIds.has(itemId)) {
            // すでに選択されている場合は選択解除
            selectedItemIds.delete(itemId);
            if (checkbox) checkbox.checked = false;
        } else {
            // 未選択の場合は選択
            selectedItemIds.add(itemId);
            if (checkbox) checkbox.checked = true;
        }

        updateSelectedCount();
    }

    // 選択数の更新とボタンテキストの変更
    function updateSelectedCount() {
        const count = selectedItemIds.size;
        selectedCountElement.textContent = count;

        // 選択数に応じてボタンの有効/無効を切り替え
        const hasSelection = count > 0;
        toggleWearBtn.disabled = !hasSelection;
        multiDeleteBtn.disabled = !hasSelection;
        if (!hasSelection) {
            return;
        }

        // 全てのアイテムが「今日着た！」状態かどうかチェック
        let allWeared = true;
        // 選択されたアイテムIDに対応するDOMエレメントを取得して確認
        selectedItemIds.forEach((itemId) => {
            const card = document.querySelector(`.js-item[data-item-id="${itemId}"]`);
            if (card && card.dataset.isWeared !== '1') {
                allWeared = false;
            }
        });
        // ボタンのテキストを更新
        if (allWeared && count > 0) {
            toggleWearBtn.textContent = 'まとめて解除';
        } else {
            toggleWearBtn.textContent = 'まとめて今日着た！';
        }
    }

    // 選択されたアイテムIDの取得
    function getSelectedItemIds() {
        return Array.from(selectedItemIds);
    }

    // 着用状態に基づいて選択されたアイテムIDを取得
    function getSelectedItemIdsByWearStatus(weared) {
        const result = [];
        selectedItemIds.forEach((itemId) => {
            const card = document.querySelector(`.js-item[data-item-id="${itemId}"]`);
            if (card) {
                const isWeared = card.dataset.isWeared === '1';
                if (weared === isWeared) {
                    result.push(itemId);
                }
            }
        });
        return result;
    }

    // CSRFトークンの取得
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // アイテムカードをクリックした時の処理 (パフォーマンス向上のためにdocumentレベルで登録)
    document.addEventListener('click', function (e) {
        // 複数選択モードがアクティブかつ、js-item内部の要素がクリックされた場合
        if (isMultiSelectMode) {
            // クリックされた要素またはその親がjs-itemクラスを持っているか確認
            const itemCard = e.target.closest('.js-item[data-selectable="true"]');
            if (itemCard) {
                e.preventDefault();
                toggleItemSelection(itemCard);
            }
        }
    });

    // イベントリスナー設定
    multiSelectBtn.addEventListener('click', () => toggleMultiSelectMode(true));
    cancelSelectionBtn.addEventListener('click', () => toggleMultiSelectMode(false));

    // まとめて今日着た！ / まとめて解除 ボタン
    toggleWearBtn.addEventListener('click', async () => {
        if (selectedItemIds.size === 0) {
            return;
        }

        // 全て「今日着た！」状態かどうかチェック
        const allWeared = getSelectedItemIdsByWearStatus(true).length === selectedItemIds.size;

        try {
            let response;

            if (allWeared) {
                // 「まとめて解除」の処理
                const wearedItemIds = getSelectedItemIdsByWearStatus(true);
                response = await bulkToggleWear(false, wearedItemIds);
            } else {
                // 「まとめて今日着た！」の処理
                // 着ていないアイテムだけ「今日着た！」に設定
                const notWearedItemIds = getSelectedItemIdsByWearStatus(false);
                response = await bulkToggleWear(true, notWearedItemIds);
            }

            if (response.status >= 200 && response.status < 300) {
                window.location.reload();
            } else {
                console.error('一括操作に失敗しました');
            }
        } catch (error) {
            console.error('エラー:', error);
        }
    });

    // まとめて削除ボタン（確認モーダル表示）
    multiDeleteBtn.addEventListener('click', () => {
        if (selectedItemIds.size > 0) {
            deleteConfirmModal.showModal();
        }
    });

    // 削除確認
    confirmDeleteBtn.addEventListener('click', async () => {
        const itemIds = getSelectedItemIds();
        if (itemIds.length === 0) {
            return;
        }

        try {
            const response = await bulkDeleteItems(itemIds);

            if (response.status >= 200 && response.status < 300) {
                window.location.reload();
            } else {
                console.error('一括削除に失敗しました');
            }
        } catch (error) {
            console.error('エラー:', error);
        } finally {
            deleteConfirmModal.close();
        }
    });

    // 初期状態で更新
    updateSelectedCount();
});
