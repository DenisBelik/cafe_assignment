import Vue from "vue";
import VueRouter from "vue-router";

import router from "@/router";
import App from '@/components/App'

Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    router,
    ...App,
    render: h => h(App),
});
