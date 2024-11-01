import { reactive } from "vue";
import axios from "axios";
import { useToast } from "vue-toastification";
import router from "../router";

const toast = useToast();

const stateAuth = reactive({
    isAuthenticated: false,
    user: null,
    errors: {},
});

// set token and update authentication function

const setToken = (token) => {
    stateAuth.errors = {};
    localStorage.setItem("token", token);
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    stateAuth.isAuthenticated = true;
};

//---login function ----
const login = async (email, password) => {
    const response = await axios.post("/login", { email, password });
    if (response.data.status == 200) {
        setToken(response.data.token);
        toast.success(response.data.success);
        router.push({ name: "home" });
    } else if (response.data.status == 401) {
        toast.error(response.data.error);
    } else if (response.data.status == 422) {
        stateAuth.errors = response.data.errors;
    }
};

//---check auth ----
const checkAuth = () => {
    const token = localStorage.getItem("token");
    if (token) {
        setToken(token);
    }   
};

export function useAuth() {
    return {
        stateAuth,
        login,
        checkAuth,
    };
}
