<template>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4 login-card">
            <!-- <h2 class="text-center mb-4">Track My Funds - Login</h2> -->
            <h2 class="text-center mb-4">Login</h2>
            <form @submit.prevent="LoginSubmit">
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control input-custom" id="email" v-model="InputData.email"
                        autocomplete="off" placeholder="Enter your email" />
                    <p v-if="errors.email" class="text-danger mt-2">{{ errors.email[0] }}</p>
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-custom" id="password" v-model="InputData.password"
                        autocomplete="off" placeholder="Enter your password" />
                    <p v-if="errors.password" class="text-danger mt-2">{{ errors.password[0] }}</p>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="mt-3 text-center">
                    Don't have an account? <router-link to="/register">Register</router-link>
                </p>
            </form>
        </div>
    </div>
</template>

<script setup>

import { computed, reactive } from 'vue'
import { useAuth } from '../../../auth/auth';

const InputData = reactive({
    email: '',
    password: ''
})
const { login, stateAuth } = useAuth()
const errors = computed(() => stateAuth.errors)

const LoginSubmit = async () => {
    await login(InputData.email, InputData.password)
}

</script>


<style scoped>
.container {
    background: #f7f9fc;
}

.login-card {
    border-radius: 10px;
    max-width: 500px;
    /* Increased width */
    width: 100%;
    /* Full width on smaller screens */
}

.input-custom:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style>
