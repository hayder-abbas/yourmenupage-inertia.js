import "./bootstrap";
import "../css/app.css";

import { createSSRApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { VueReCaptcha } from "vue-recaptcha-v3";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        return (
            createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                // Initialize reCAPTCHA using the Inertia shared prop
                .use(VueReCaptcha, {
                    siteKey: props.initialPage.props.recaptcha_site_key,
                })
                .use(ZiggyVue)
                .mount(el)
        );
    },
    progress: {
        color: "#f97316",
    },
});
