<template>
    <!-- Sidebar -->
    <nav class="sidebar">
        <h3 class="text-center mb-4">Game Dashboard</h3>
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('games') }}"><i class="fas fa-gamepad"></i> Games</a>
        <a href="#"><i class="fas fa-chart-line"></i> Analytics</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
    </nav>
</template>