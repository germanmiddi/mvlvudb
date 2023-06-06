require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Layout from './Layouts/Layout'
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Desarrollo Social';



createInertiaApp({
    title: (title) => `${title} - ${appName}`,
//    resolve: (name) => require(`./Pages/${name}.vue`),
    resolve: name => {
        let page = require(`./Pages/${name}.vue`).default
        
        if(!page.layout && !name.startsWith('Auth') ){
            page.layout = Layout
        }
        return page
    },

    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
