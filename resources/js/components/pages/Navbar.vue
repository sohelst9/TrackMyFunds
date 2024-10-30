<template>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Track My Funds</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><router-link class="nav-link text-white"
                            :to="{ name: 'home' }">Home</router-link>
                    </li>
                    <li class="nav-item"><router-link class="nav-link text-white" :to="{ name: 'trnx.add' }">Add
                            Transaction</router-link></li>
                    <li class="nav-item"><a class="nav-link text-white" href="trnx_history.html">History</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="statistics.html">Statistics</a></li>
                </ul>
                <button @click="toggletheme" id="toggleTheme" class="btn btn-outline-light ms-3">
                    {{ isDarkmood ? 'Light Mood' : 'Dark Mode' }}
                </button>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const isDarkmood = ref('false');
const toggletheme = () => {
    isDarkmood.value = !isDarkmood.value
    document.body.classList.toggle("dark-mode", isDarkmood.value);
    localStorage.setItem('darkMood', isDarkmood.value)
}

onMounted(() => {
    const themeStore = localStorage.getItem('darkMood');
    if (themeStore !== null) {
        isDarkmood.value = themeStore === 'true'
        document.body.classList.toggle("dark-mode", isDarkmood.value);
    }
})
</script>