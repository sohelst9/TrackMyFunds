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
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control input-custom" v-model="FormData.email" id="email"
                        placeholder="Enter your email" />
                </div>

                <div class="form-group mb-3">
                    <label for="profile">Profile</label>
                    <input type="file" class="form-control input-custom" @change="profileChange" id="profile" />
                    <img v-if="previewImage" :src="previewImage" alt="" height="100" width="100" class="mt-3">
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-custom" v-model="FormData.password" id="password"
                        placeholder="Create a password" />
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="mt-3 text-center">
                    Already have an account? <router-link to="/">Login</router-link>
                </p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios';


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

const RegisterSubmit = async () => {
    errors.value = {};
    try {
        const response = await axios.post('/api/register', FormData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        // console.log(response);

        if(response.data.success){
            console.log(response.data.success)
        }else{

        }

        
    } catch (error) {
        console.error(error)
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

.dark-mode .container {
    background: #1a1a1a;
    color: #f7f9fc;
}

.dark-mode .register-card {
    background: #2a2a2a;
    border: 1px solid #444;
}

.dark-mode .input-custom {
    background: #333;
    color: #f7f9fc;
    border: 1px solid #444;
}

.dark-mode .input-custom::placeholder {
    color: #888;
    /* Dark mode placeholder color */
}

.dark-mode h2,
p,
label {
    color: #f7f9fc;
}


.dark-mode .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.dark-mode .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>
