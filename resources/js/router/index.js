import { createRouter, createWebHistory } from "vue-router"
import Home from "../components/pages/Home.vue"
import About from "../components/pages/About.vue"
import Notfound from "../components/pages/Notfound.vue"
const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },
    {path: '/:pathMatch(.*)*', name: 'notfound', component: Notfound}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
