import axios from 'axios';

// CSRFトークンの取得
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

// Axiosインスタンスの作成
const instance = axios.create({
    baseURL: '/',
    timeout: 1000,
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
    },
});

export const getWearDates = async (itemId) => {
    try {
        const response = await instance.get(`wear-log/${itemId}`);
        return response.data;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const updateWearLogs = async (wearDatesToAdd, wearDatesToDelete, itemId) => {
    try {
        const response = await instance.post(`wear-log/update/${itemId}`, {
            wearDatesToAdd,
            wearDatesToDelete,
        });
        return response;
    } catch (error) {
        console.error(error);
        throw error;
    }
};

export const bulkToggleWear = async (isWear, itemIds) => {
    try {
        if (isWear) {
            // 「まとめて今日着た！」の処理
            return await instance.post('wear-logs/bulk', {
                item_ids: itemIds,
            });
        } else {
            // 「まとめて解除」の処理
            return await instance.post('wear-logs/bulk-delete', {
                item_ids: itemIds,
            });
        }
    } catch (error) {
        console.error('エラー:', error);
        throw error;
    }
};

export const bulkDeleteItems = async (itemIds) => {
    try {
        return await instance.post('items/bulk-delete', {
            item_ids: itemIds,
        });
    } catch (error) {
        console.error('エラー:', error);
        throw error;
    }
};
