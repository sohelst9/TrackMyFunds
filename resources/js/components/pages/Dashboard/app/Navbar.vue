<template>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Profile link goes to the right side -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'admin_user' }"><fontawesome-icon icon="user" />
                            Profile</router-link>
                    </li>
                </ul>
                <!-- Logout button stays on the left side -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="nav-link" @click="Logout"><fontawesome-icon icon="sign-out-alt" />
                            Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



</template>

<script setup>
import { useAuth } from '../../../../auth/auth';

const { logout } = useAuth()

//---Logout
const Logout = async () => {
    await logout()
}

</script>