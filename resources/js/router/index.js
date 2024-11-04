import { createRouter, createWebHistory } from "vue-router";
import About from "../components/pages/About.vue";
import Notfound from "../components/pages/Notfound.vue";
import Add from "../components/pages/trnx/Add.vue";
import Login from "../components/pages/auth/Login.vue";
import Register from "../components/pages/auth/Register.vue";
import { useAuth } from "../auth/auth";
import Home from "../components/pages/Dashboard/Home.vue";
import UserSection from "../components/pages/Dashboard/UserSection.vue";
import ViewProduct from "../components/pages/Dashboard/product/ViewProduct.vue";
import Addproduct from "../components/pages/Dashboard/product/Addproduct.vue";

const routes = [
    //---dashboard routes -----
    {
        path: "/",
        name: "login",
        component: Login,
        meta: { requiresGuest: true },
    },

    {
        path: "/register",
        name: "register",
        component: Register,
        meta: { requiresGuest: true },
    },

    {
        path: "/dashboard",
        name: "home",
        component: Home,
        meta: { requiresAuth: true },
    },

    {
        path: "/admin/user",
        name: "admin_user",
        component: UserSection,
        meta: { requiresAuth: true },
    },

    {
        path: "/admin/products",
        name: "admin_products",
        component: ViewProduct,
        meta: { requiresAuth: true },
    },

    {
        path: "/admin/product/add",
        name: "admin_product_add",
        component: Addproduct,
        meta: { requiresAuth: true },
    },

    {
        path: "/about",
        name: "about",
        component: About,
        meta: { requiresAuth: true },
    },
    {
        path: "/add-trnx",
        name: "trnx.add",
        component: Add,
        meta: { requiresAuth: true },
    },

    { path: "/:pathMatch(.*)*", name: "notfound", component: Notfound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const { stateAuth } = useAuth();
    // Access to authenticated routes is restricted if not logged in
    if (to.meta.requiresAuth && !stateAuth.isAuthenticated) {
        next({ name: "login" });
    }
    // Access to login/register pages is restricted when authenticated.
    else if (to.meta.requiresGuest && stateAuth.isAuthenticated) {
        next({ name: "home" });
    } else {
        next();
    }
});

export default router;
