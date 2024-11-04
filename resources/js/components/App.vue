<template>
    <Sidebar v-if="showHeaderFooter" />
    <Navbar v-if="showHeaderFooter" />
    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <router-view />
        </div>
    </div>

    <Footer v-if="showHeaderFooter" />
</template>

<script setup>

import Footer from './pages/Footer.vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import Sidebar from './pages/Dashboard/app/Sidebar.vue';
import Navbar from './pages/Dashboard/app/Navbar.vue';

const route = useRoute();
const showHeaderFooter = computed(() => !['login', 'register'].includes(route.name));
</script>