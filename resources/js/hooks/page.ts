import {computed, ComputedRef} from "vue";
import {usePage} from "@inertiajs/vue3";

export function usePageProp<T>(key: string): ComputedRef<T|null> {
    const page = usePage();
    const pageProps = page.props;

    return computed(() => {
       if (key in pageProps) {
           return pageProps[key] as T;
       }

       return null;
    });
}
