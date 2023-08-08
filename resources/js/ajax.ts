import axios, {AxiosError, AxiosInstance, AxiosResponse} from "axios";
import {toastManager, ToastStyle} from "@/toasts";

function getErrorMessage(error: AxiosError) {
    const response = error.response as AxiosResponse<any>;

    if (!response) {
        return error.message;
    }

    if (response.data.message) {
        return response.data.message;
    }

    return `${response.status} ${response.statusText}`;
}

function createApiAxios() {
    const apiAxios = axios.create({
            baseURL: '/api',
        });

    apiAxios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    apiAxios.interceptors.response.use(response => {
            return response;
        },

        function (error: AxiosError) {
            toastManager.add(getErrorMessage(error), ToastStyle.Error);
            return Promise.reject(error);
        });

    return apiAxios;
}

export const apiAxios: AxiosInstance = createApiAxios();



