<template>
 <Navbar v-if="showHeaderFooter" />
 <router-view/>
 <Footer v-if="showHeaderFooter" />
</template>

<script setup>
import Navbar from './pages/Navbar.vue'
import Footer from './pages/Footer.vue'
import {useRoute} from 'vue-router'
import {computed} from 'vue'

const route = useRoute();
const showHeaderFooter = computed(() => !['login'].includes(route.name));
</script>