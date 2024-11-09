<template>
    <!-- if layout dashboard then show all  dashboard  layout  -->
    <Sidebar v-if="isDashboard" />
    <Navbar v-if="isDashboard" />
    <!-- Main Content -->
    <div v-if="isDashboard" class="main-content">
        <div class="container mt-4">
            <router-view />
        </div>
    </div>

    <div v-else>
        <router-view />
    </div>

    <!-- <Footer v-if="showHeaderFooter" /> -->
</template>

<script setup>

import Footer from './pages/Footer.vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import Sidebar from './pages/Dashboard/app/Sidebar.vue';
import Navbar from './pages/Dashboard/app/Navbar.vue';

const route = useRoute();
// const showHeaderFooter = computed(() => !['login', 'register', 'notfound'].includes(route.name));

// layout based condtion and show dashboard
const isDashboard = computed(() => route.meta.layout === 'dashboard');
</script>