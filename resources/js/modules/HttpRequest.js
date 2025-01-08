import axios from 'axios';

const instance = axios.create({
    baseURL: '/',
    timeout: 1000,
});

export const getWearDates = async (itemId) => {
    try {
        const response = await instance.get(`wear_log/${itemId}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
};

export const updateWearLogs = async (wearDatesToAdd, wearDatesToDelete, itemId) => {
    try {
        const response = await instance.post(`wear_log/update/${itemId}`, {
            wearDatesToAdd,
            wearDatesToDelete,
        });
    } catch (error) {
        console.error(error);
    }
};
