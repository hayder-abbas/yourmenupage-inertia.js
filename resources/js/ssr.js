import { createSSRApp, h } from "vue";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import { createInertiaApp } from "@inertiajs/vue3";
import { renderToString } from "@vue/server-renderer";
import createServer from "@inertiajs/vue3/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { VueReCaptcha } from "vue-recaptcha-v3";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue"),
            ),
        setup({ App, props, plugin }) {
            return (
                createSSRApp({ render: () => h(App, props) })
                    .use(plugin)
                    // Initialize reCAPTCHA using the Inertia shared prop
                    .use(VueReCaptcha, {
                        siteKey: props.initialPage.props.recaptcha_site_key,
                    })
                    .use(pinia)
                    .use(ZiggyVue, {
                        ...page.props.ziggy,
                        location: new URL(page.props.ziggy.location),
                    })
            );
        },
    }),
);
