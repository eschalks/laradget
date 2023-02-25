import {inject, InjectionKey, provide, reactive} from "vue";

export class Dialog {
    isOpen: boolean = false;

    open() {
        this.isOpen = true;
    }

    close() {
        this.isOpen = false;
    }
}

const dialogInjectionKey: InjectionKey<Dialog> = Symbol('dialog');

export function useDialog(): Dialog {
    const injectedDialog = inject(dialogInjectionKey, null);
    if (injectedDialog) {
        return injectedDialog;
    }

    const newDialog = reactive(new Dialog());
    provide(dialogInjectionKey, newDialog)
    return newDialog;
}
