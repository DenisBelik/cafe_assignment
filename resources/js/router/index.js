import VueRouter from "vue-router";
import Home from "@/pages/home"

export default new VueRouter({
    routes: [
        { path: '/', component: Home }
    ]
});
