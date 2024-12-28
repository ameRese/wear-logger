// 兄弟ノードを検索
const searchSiblingNode = (currentNode, className) => {
    let sibling = currentNode.nextElementSibling;
    while (sibling) {
        if (sibling.className === className) { return sibling; }
        sibling = sibling.nextElementSibling;
    }
}

// モーダル背景クリック時にモーダルを閉じる
const backdropClickHandler = (e, modal) => {
    if (e.target === modal) {
        modal.close();
    }
};

// モーダルを開く
const openModal = e => {
    e.preventDefault();
    // targetプロパティはクリックされた具体的な子要素を指すのでcurrentTargetを使う
    const modal = searchSiblingNode(e.currentTarget, 'js-modal');
    modal.showModal();
    modal.addEventListener('click', e => backdropClickHandler(e, modal));
};

const items = document.querySelectorAll('.js-item');
for (let item of items) {
    item.addEventListener('click', e => openModal(e));
}
