// モーダル操作用のデータ
const modalState = {
    isMultiSelectMode: false, // 複数選択モードかどうか
};

// グローバルにエクスポートして他のモジュールからアクセス可能にする
window.modalState = modalState;

// 対象がモーダル背景またはキャンセルボタンの場合にモーダルを閉じる
const closeModal = (e, modal) => {
    if (e.target === modal || e.target.className.includes('js-cancel')) {
        modal.close();
    }
};

// 登録リスナー削除時のためにイベントリスナーの関数参照を保持
const modalClickHandler = (e) => closeModal(e, e.currentTarget);

// モーダルを開く
const openModal = (e) => {
    // 複数選択モード中はモーダルを開かない
    if (modalState.isMultiSelectMode) {
        return;
    }

    e.preventDefault();
    // クリックイベントの登録要素を取得するためにtargetでなくcurrentTargetプロパティを使う
    const modalId = e.currentTarget.getAttribute('data-modal-target');
    const modal = document.getElementById(modalId);
    // クリックイベントが重複しないようにイベントリスナーを削除してから登録する
    modal.removeEventListener('click', modalClickHandler);
    modal.addEventListener('click', modalClickHandler);
    modal.showModal();
};

const links = document.querySelectorAll('[data-modal-target]');
for (let link of links) {
    link.addEventListener('click', (e) => openModal(e));
}
