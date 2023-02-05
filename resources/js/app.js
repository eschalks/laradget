import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import MainLayout from './layouts/MainLayout.vue';

createInertiaApp({
    resolve: async name => {
        const module = await import(`./pages/${name}.vue`);
        if (!module) {
            return null;
        }

        const page = module.default;

        if (name !== 'LoginPage') {
            page.layout = MainLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
