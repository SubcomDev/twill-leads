import './bootstrap';

/**
 *
 */

import { createApp } from "vue";
import { defineAsyncComponent } from 'vue';




/**
 * mixins
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import axios from 'axios';
import axiosWrapper from './mixins/axiosWrapper';

const app = createApp({
    data() {
        return {
            base_url: process.env.MIX_APP_VUE_ROUTER_BASE
        }
    },
});



/**
 *  Lazy Loading comnponents
 */
app.component('NewsletterForm', defineAsyncComponent(() =>
    import('./components/NewsletterForm.vue')
));



/**
 *
 */
app.config.globalProperties.axios = axios
app.mixin(axiosWrapper);
app.mount("#app");

