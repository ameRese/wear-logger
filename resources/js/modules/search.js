document.addEventListener('DOMContentLoaded', () => {
    let itemDictionary = [];

    // 対象の子孫ノードの中から対象のクラス名を含んだ要素を1つ返す
    const searchDescendantNode = (currentNode, className) => {
        const children = currentNode.children;
        for (let child of children) {
            // 再帰的に子ノードを検索
            const result = searchDescendantNode(child, className);
            if (result) {
                return result;
            }
            if (child.className.includes(className)) {
                return child;
            }
        }
        // 対象がない場合はnullを返す
        return null;
    };

    // アイテム要素から検索用配列を作成
    const generateItemDictionary = () => {
        const items = document.querySelectorAll('.js-item');
        itemDictionary = [];
        items.forEach((item) => {
            const category = searchDescendantNode(item, 'js-category');
            const brand = searchDescendantNode(item, 'js-brand');
            const name = searchDescendantNode(item, 'js-name');
            if (category && brand && name) {
                itemDictionary.push({
                    item: item,
                    category: category.textContent.toLowerCase(),
                    brand: brand.textContent.toLowerCase(),
                    name: name.textContent.toLowerCase(),
                });
            }
        });
    };

    // インクリメンタルサーチ
    const searchIncrementally = (inputText) => {
        const searchText = inputText.toLowerCase();
        itemDictionary.forEach((entry) => {
            const isMatch =
                entry.category.includes(searchText) ||
                entry.brand.includes(searchText) ||
                entry.name.includes(searchText);

            entry.item.classList.toggle('hidden', !isMatch);
        });
    };

    // 初期化
    const init = () => {
        generateItemDictionary();
        document
            .getElementById('js-search')
            .addEventListener('input', (e) => searchIncrementally(e.target.value));
    };

    init();
});
