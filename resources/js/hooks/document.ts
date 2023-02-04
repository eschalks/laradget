import {onUnmounted, Ref, watch} from "vue";

export function useDocumentTitle(title: Ref<string>) {
    watch(title, newTitle => {
        document.title = newTitle;
    }, {immediate: true});

    onUnmounted(() => document.title = 'Budget');
}
