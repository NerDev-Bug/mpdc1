import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createSSRApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

type ZiggyConfig = NonNullable<Parameters<typeof ZiggyVue.install>[1]>;
type SerializedZiggyConfig = Omit<ZiggyConfig, 'location'> & { location: string };

const appName = import.meta.env.VITE_APP_NAME || 'MPDC';

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => (title ? `${title} - ${appName}` : appName),
        resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
        setup({ App, props, plugin }) {
            const serializedZiggy = props.initialPage.props.ziggy as SerializedZiggyConfig;
            const ziggy: ZiggyConfig = {
                ...serializedZiggy,
                location: new URL(serializedZiggy.location),
            };

            return createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, ziggy);
        },
    }),
);
