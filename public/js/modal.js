// 兄弟ノードを検索して見つかった要素を返す
const searchSiblingNode = (currentNode, className) => {
    let sibling = currentNode.nextElementSibling;
    while (sibling) {
        if (sibling.className.includes(className)) { return sibling; }
        sibling = sibling.nextElementSibling;
    }
    return null;
}

// 対象がモーダル背景またはキャンセルボタンの場合にモーダルを閉じる
const closeModal = (e, modal) => {
    if (e.target === modal || e.target.className.includes('js-cancel')) {
        modal.close();
    }
};

// 登録リスナー削除時のためにイベントリスナーの関数参照を保持
const modalClickHandler = e => closeModal(e, e.currentTarget);

// モーダルを開く
const openModal = e => {
    e.preventDefault();
    // クリックイベントの登録先を取得するためにtargetでなくcurrentTargetプロパティを使う
    const modal = searchSiblingNode(e.currentTarget, 'js-modal');
    // クリックイベントが重複しないようにイベントリスナーを削除してから登録する
    modal.removeEventListener('click', modalClickHandler);
    modal.addEventListener('click', modalClickHandler);
    modal.showModal();
};

const links = document.querySelectorAll('.js-link');
for (let link of links) {
    link.addEventListener('click', e => openModal(e));
}
