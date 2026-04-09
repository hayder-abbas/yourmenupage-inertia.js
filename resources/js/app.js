import "./bootstrap";
import "../css/app.css";

import { createSSRApp, h } from "vue";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
  title: (title) => `${title} | ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue"),
    ),
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .component("Link", Link)
      .component("Head", Head)
      .mount(el);
  },
  progress: {
    color: "#4B5563",
  },
});
