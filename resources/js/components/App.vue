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
    <!-- if layout frontend then show all  frontend  layout  -->
    <div v-else-if="isFrontEnd">
        <router-view />
    </div>

    <!-- if  not layout frontend and dashboard then show others all page  -->
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

// layout based condtion and show frontend and dashboard
const isDashboard = computed(() => route.meta.layout === 'dashboard');
const isFrontEnd = computed(() => route.meta.layout === 'frontend');
</script>