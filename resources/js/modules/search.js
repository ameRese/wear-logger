let itemDictionary = [];

// 対象の子孫ノードの中から対象のクラス名を含んだ要素を1つ返す
const searchDescendantNode = (currentNode, className) => {
    const children = currentNode.children;
    for (let child of children) {
        // 再帰的に子ノードを検索
        const result = searchDescendantNode(child, className);
        if (result) { return result; }
        if (child.className.includes(className)) { return child; }
    }
    // 対象がない場合はnullを返す
    return null;
};

// アイテム要素から検索用配列を作成
const generateItemDictionary = () => {
    const items = document.querySelectorAll('.js-item');
    itemDictionary = [];
    for (let item of items) {
        const category = searchDescendantNode(item, 'js-category');
        const brand = searchDescendantNode(item, 'js-brand');
        const name = searchDescendantNode(item, 'js-name');
        itemDictionary.push({
            'item': item,
            'category': category.textContent,
            'brand': brand.textContent,
            'name': name.textContent,
        })
    }
};

// インクリメンタルサーチ
const searchIncrementally = inputText => {
    itemDictionary.forEach(entry => {
        if (entry.category.includes(inputText) ||
            entry.brand.includes(inputText) ||
            entry.name.includes(inputText)) {
                entry.item.classList.remove('hidden');
            } else {
                entry.item.classList.add('hidden');
            }
    });
};

document.addEventListener('DOMContentLoaded', generateItemDictionary);
document.getElementById('js-search').addEventListener('input', e => searchIncrementally(e.target.value));
