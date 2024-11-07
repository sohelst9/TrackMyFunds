<template>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4 register-card">
            <h2 class="text-center mb-4">Register</h2>
            <!-- <h2 class="text-center mb-4">Track My Funds - Register</h2> -->
            <form @submit.prevent="RegisterSubmit">
                <div class="form-group mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control input-custom" v-model="FormData.name" id="name"
                        placeholder="Enter your full name" />
                    <p v-if="errors.name" class="text-danger">{{ errors.name[0] }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control input-custom" v-model="FormData.email" id="email"
                        placeholder="Enter your email" />

                    <p v-if="errors.email" class="text-danger">{{ errors.email[0] }}</p>
                </div>

                <div class="form-group mb-3">
                    <label for="profile">Profile</label>
                    <input type="file" class="form-control input-custom" @change="profileChange" id="profile" />
                    <img v-if="previewImage" :src="previewImage" alt="" height="100" width="100" class="mt-3">

                    <p v-if="errors.profile" class="text-danger">{{ errors.profile[0] }}</p>
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-custom" v-model="FormData.password" id="password"
                        placeholder="Create a password" />
                    <p v-if="errors.password" class="text-danger">{{ errors.password[0] }}</p>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="mt-3 text-center">
                    Already have an account? <router-link :to="{name: 'login'}">Login</router-link>
                </p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { useRouter } from 'vue-router';


const previewImage = ref(null);
const FormData = reactive({
    name: '',
    email: '',
    profile: null,
    password: ''
});

const profileChange = (e) => {
    const fileget = e.target.files[0];
    FormData.profile = fileget;
    previewImage.value = URL.createObjectURL(FormData.profile)
}

const errors = reactive({});
const toast = useToast()
const router = useRouter()

const RegisterSubmit = async () => {
    Object.keys(errors).forEach(key => delete errors[key]);
    const response = await axios.post('/register', FormData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })

    if (response.data.status === 200) {
        toast.success('Registration successful, please login')
        router.push('/');
    } else if (response.data.status === 422) {
        console.log(response.data.status);
        Object.assign(errors, response.data.errors);
    } else {
        console.log("An unexpected error occurred.");
    }

}

</script>

<style scoped>
.container {
    background: #f7f9fc;
}

.register-card {
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
