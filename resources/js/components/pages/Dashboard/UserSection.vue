<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card user_card shadow-lg">
                    <div class="user_card-header text-center">
                        <h4>User Information</h4>
                    </div>
                    <div class="user_card-body d-flex align-items-center justify-content-between" v-if="user">
                        <div class="user_info">
                            <div class="text-center mb-3">
                                <img :src="profileImage" alt="User Avatar"
                                    class="user_avatar rounded-circle shadow-sm" />
                            </div>
                            <p class="user_card-title">Name : {{ user.name }}</p>
                            <p class="user_card-text"><strong>Email:</strong> {{ user.email }}</p>
                        </div>
                        <div class="user_buttons text-end">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary user_btn" type="button">Edit Profile</button>
                                <button class="btn btn-danger user_btn" type="button"
                                    @click="handleLogout">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useAuth } from '../../../auth/auth';


const { logout, stateAuth } = useAuth() // {} this is destructuring

//--current user info
const user = computed(() => stateAuth.user);

console.log(user.value)

//--profile url make
const profileImage = computed(() => {
    return `/storage/${user.value.profile}`;
});


//--cal logout function
const handleLogout = async () => {
    await logout()
}
</script>

<style scoped>
.user_card {
    border-radius: 20px;
    /* Rounded corners for card */
    border: 2px solid #007bff;
    /* Border color */
    transition: transform 0.2s, box-shadow 0.2s;
    /* Smooth transition for hover effect */
}

.user_card:hover {
    transform: translateY(-5px);
    /* Slight lift on hover */
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
    /* Enhanced shadow on hover */
}

.user_card-header {
    background-color: #0056b3;
    /* Darker primary color for header */
    color: white;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 15px 0;
}

.user_card-body {
    padding: 20px;
    background-color: #f0f4ff;
    /* Light background color */
    border-radius: 0px 0px 20px 20px;
}

.user_avatar {
    width: 100px;
    /* Fixed size for user avatar */
    height: 100px;
    border: 4px solid #007bff;
    /* Border for avatar */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    /* Subtle shadow for avatar */
}

.user_card-title {
    font-weight: bold;
    margin: 10px 0;
    color: #343a40;
    /* Dark text color */
}

.user_card-text {
    margin: 5px 0;
    color: #495057;
    /* Slightly lighter text color */
}

.user_buttons {
    text-align: right;
    /* Align buttons to the right */
}

.user_btn {
    border-radius: 5px;
    /* Rounded corners for buttons */
    padding: 10px;
    font-size: 14px;
    transition: background-color 0.2s, transform 0.2s;
    /* Smooth transition */
}

.user_btn:hover {
    transform: scale(1.05);
    /* Slightly enlarge on hover */
}

.user_btn.btn-danger:hover {
    background-color: #dc3545;
    /* Darker red on hover */
    color: white;
    /* Keep text color white */
}
</style>
