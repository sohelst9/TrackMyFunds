<template>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4 login-card">
            <!-- <h2 class="text-center mb-4">Track My Funds - Login</h2> -->
            <h2 class="text-center mb-4">Login</h2>
            <form>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control input-custom" id="email" autocomplete="off" placeholder="Enter your email" />
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-custom" id="password" autocomplete="off" placeholder="Enter your password" />
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="mt-3 text-center">
                    Don't have an account? <router-link to="/register">Register</router-link>
                </p>
            </form>
        </div>
    </div>
</template>

<style scoped>
.container {
    background: #f7f9fc;
}

.login-card {
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

.dark-mode .login-card {
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
