<template>
    <div class="footer text-center mb-3 mt-4">
        <p class="mb-0">© {{ year }} Expense Tracker. All Rights Reserved.</p>
    </div>
</template>

<script setup>
const year = new Date().getFullYear();
</script>