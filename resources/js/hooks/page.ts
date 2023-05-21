import {computed, ComputedRef, getCurrentInstance, Ref,} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import {CategoryGroupDto} from "@/generated/generated";



export function usePageProp<T>(key: string, defaultFactory: () => T): ComputedRef<T|null> {
    const page = usePage();

    return computed(() => {
        const pageProps = page.props;

       if (pageProps && key in pageProps) {
           return pageProps[key] as T;
       }

       return defaultFactory();
    });
}

export function useCategoryGroups() {
    return usePageProp<CategoryGroupDto[]>('categoryGroups', () => {
        console.warn('Page is missing category groups. Please call CategoryGroupDto::shareWithInertia()');
        return [];
    });
}


export function usePageRef() {
    return computed(() => getCurrentInstance()?.appContext.app.config.globalProperties.$page);
}

export function useCurrentUrl(): Ref<string | undefined> {
    return computed(() => usePageRef().value?.url);
}
