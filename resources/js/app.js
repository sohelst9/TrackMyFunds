import "./bootstrap";

import { createApp } from "vue";
import Toast from "vue-toastification";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "vue-toastification/dist/index.css";

import App from "./components/App.vue";
import router from "./router";
import axios from "axios";
import { useAuth } from "./auth/auth";

axios.defaults.baseURL = "/api";
axios.defaults.withCredentials = true;

const app = createApp(App);
// Verify the token during app loading
const { checkAuth } = useAuth();
checkAuth();
app.use(router);
app.use(Toast);
app.mount("#app");
