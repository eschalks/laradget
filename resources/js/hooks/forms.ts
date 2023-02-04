import {InertiaForm} from "@inertiajs/inertia-vue3";
import {inject, InjectionKey, provide, Ref} from "vue";


const formKey: InjectionKey<Ref<InertiaForm<unknown>>> = Symbol();

export function provideForm(form: Ref<InertiaForm<unknown>>) {
    provide(formKey, form);
}

export function injectForm<TData>(): Ref<InertiaForm<TData>> {
    const form = inject(formKey, null);
    if (!form) {
        throw Error('injectForm can only be used within a component that provides a form. (e.g. FormCard)');
    }

    return form as Ref<InertiaForm<TData>>;
}
