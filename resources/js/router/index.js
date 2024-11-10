import { createRouter, createWebHistory } from "vue-router";
import Notfound from "../components/pages/Notfound.vue";
import Login from "../components/pages/auth/Login.vue";
import Register from "../components/pages/auth/Register.vue";
import { useAuth } from "../auth/auth";
import Home from "../components/pages/Dashboard/Home.vue";
import UserSection from "../components/pages/Dashboard/UserSection.vue";
import ViewProduct from "../components/pages/Dashboard/product/ViewProduct.vue";
import Addproduct from "../components/pages/Dashboard/product/Addproduct.vue";
import EditProduct from "../components/pages/Dashboard/product/editProduct.vue";
import CategoryAdd from "../components/pages/Dashboard/category/CategoryAdd.vue";

const routes = [
    //---dashboard routes -----
    {
        path: "/",
        name: "login",
        component: Login,
        meta: {
            requiresGuest: true,
        },
    },

    {
        path: "/admin/register",
        name: "register",
        component: Register,
        meta: {
            requiresGuest: true,
        },
    },

    {
        path: "/dashboard",
        name: "home",
        component: Home,
        meta: {
            requiresAuth: true,
            layout: "dashboard",
            title: "Dashbaord | Easy Shop",
        },
    },

    {
        path: "/admin/user",
        name: "admin_user",
        component: UserSection,
        meta: {
            requiresAuth: true,
            layout: "dashboard",
        },
    },

    //-- category router

    {
        path: "/admin/categories",
        name: 'admin_categories',
        component: CategoryAdd,
        meta:{
            requiresAuth: true,
            layout: 'dashboard'
        }
    },

    //---product route
    {
        path: "/admin/products",
        name: "admin_products",
        component: ViewProduct,
        meta: {
            requiresAuth: true,
            layout: "dashboard",
        },
    },

    {
        path: "/admin/product/add",
        name: "admin_product_add",
        component: Addproduct,
        meta: {
            equiresAuth: true,
            layout: "dashboard",
        },
    },

    {
        path: "/product/edit/:slug",
        name: "product_edit",
        component: EditProduct,
        props: true,
        meta: {
            requiresAuth: true,
            layout: "dashboard",
        },
    },

    //---product route end

    {
        path: "/:pathMatch(.*)*",
        name: "notfound",
        component: Notfound,
        meta: {
            title: "Not Found Page",
        },
    },
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
        //-- add page title and meta all data and others data here
        if (to.meta.title) {
            document.title = to.meta.title;
        }
        if (to.meta.description) {
            updateMetaTag("description", to.meta.description);
        }
        next();
    }
});

function updateMetaTag(name, content) {
    let tag =
        document.querySelector(`meta[name="${name}"]`) ||
        document.createElement("meta");
    tag.setAttribute("name", name);
    tag.setAttribute("content", content);
    document.head.appendChild(tag);
}

export default router;
