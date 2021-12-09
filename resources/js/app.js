require("./bootstrap");

import Vue from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue";
import { InertiaProgress } from "@inertiajs/progress";

InertiaProgress.init();

Vue.prototype.$route = route;

createInertiaApp({
    resolve: (name) => require(`./pages/${name}`),
    setup({ el, App, props }) {
        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
