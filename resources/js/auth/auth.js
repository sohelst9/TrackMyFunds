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
        stateAuth.user = response.data.user;
        toast.success(response.data.success);
        router.push({ name: "home" });
    } else if (response.data.status == 401) {
        toast.error(response.data.error);
    } else if (response.data.status == 422) {
        stateAuth.errors = response.data.errors;
    }
};

//--logout
const logout = async () => {
    try {
        const response = await axios.post("/logout");
        stateAuth.isAuthenticated = false;
        stateAuth.user = null;
        localStorage.removeItem("token");
        delete axios.defaults.headers.common["Authorization"];
        toast.success(response.data.message);
        router.push({ name: "login" });
    } catch (error) {
        toast.success("Logout failed");
    }
};

//---check auth ----
const checkAuth = async () => {
    const token = localStorage.getItem("token");
    if (token) {
        try {
            setToken(token);
            const response = await axios.get("/user");
            stateAuth.user = response.data.user;
            stateAuth.isAuthenticated = true;
            // console.log(response.data.user);
        } catch (error) {
            console.error("Failed to fetch user data:", error);
            stateAuth.isAuthenticated = false;
            stateAuth.user = null;
        }
    } else {
        stateAuth.isAuthenticated = false;
        stateAuth.user = null;
    }
};

export function useAuth() {
    return {
        stateAuth,
        login,
        checkAuth,
        logout,
    };
}
