import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, createSSRApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { initializeTheme } from './composables/useAppearance';

type ZiggyConfig = NonNullable<Parameters<typeof ZiggyVue.install>[1]>;
type SerializedZiggyConfig = Omit<ZiggyConfig, 'location'> & { location: string };

const appName = import.meta.env.VITE_APP_NAME || 'MPDC';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const serializedZiggy = props.initialPage.props.ziggy as SerializedZiggyConfig;
        const ziggy: ZiggyConfig = {
            ...serializedZiggy,
            location: new URL(serializedZiggy.location),
        };
        const createVueApp = el.hasChildNodes() ? createSSRApp : createApp;

        createVueApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
