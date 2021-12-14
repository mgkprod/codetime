require('./bootstrap');

import Vue from 'vue';
import { createInertiaApp, InertiaLink } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress';

Vue.config.productionTip = false;

Vue.mixin({
  computed: {
    _: () => window._,
  },

  methods: {
    route: window.route,
    moment: window.moment,
  },
});

InertiaProgress.init();

Vue.component('inertia-link', InertiaLink);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

createInertiaApp({
  resolve: (name) => require(`./pages/${name}`),
  setup({ el, App, props }) {
    new Vue({
      render: (h) => h(App, props),
    }).$mount(el);
  },
});
