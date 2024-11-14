import "./bootstrap";

import { createApp } from "vue";
import Toast from "vue-toastification";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "vue-toastification/dist/index.css";

//---font awesome import ---
import {library} from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from "@fortawesome/free-solid-svg-icons";

import App from "./components/App.vue";
import router from "./router";
import axios from "axios";


axios.defaults.baseURL = "/api";
axios.defaults.withCredentials = true;

library.add(fas);

const app = createApp(App);

app.component('fontawesome-icon', FontAwesomeIcon)
app.use(router);
app.use(Toast);
app.mount("#app");
