import {reactive} from "vue";
import type {AxiosError, AxiosInstance} from "axios";

export enum ToastStyle {
    Success = 'success',
    Error = 'error',
}

class ToastManager {
    toasts: Toast[] = [];

    add(message: string, style: ToastStyle, timeout = 5000) {
        const toast = {
            id: nextId++,
            message,
            style
        };

        console.log(toast);

        this.toasts.push(toast);

        setTimeout(() => {
            this.remove(toast);
        }, timeout);
    }

    remove(toast: Toast) {
        const index = this.toasts.indexOf(toast);
        if (index > -1) {
            this.toasts.splice(index, 1);
        }
    }
}

let nextId = 1;


export interface Toast {
    id: number;
    message: string;
    style: ToastStyle;
}

export const toastManager = reactive(new ToastManager());
