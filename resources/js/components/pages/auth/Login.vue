<template>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4 login-card">
            <h2 class="text-center mb-4">Login</h2>
            <form>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control input-custom" id="email" placeholder="Enter your email"
                        required />
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-custom" id="password"
                        placeholder="Enter your password" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
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
    max-width: 400px;
}

.input-custom:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* dark mood */
.dark-mode .container {
    background: #1a1a1a;
    /* Dark background */
    color: #f7f9fc;
    /* Light text color */
}

.dark-mode .login-card {
    border-radius: 10px;
    max-width: 400px;
    background: #2a2a2a;
    /* Card background */
    border: 1px solid #444;
    /* Card border */
}

.dark-mode .input-custom {
    background: #333;
    /* Input background */
    color: #f7f9fc;
    /* Input text color */
    border: 1px solid #444;
    /* Input border */
}

.dark-mode .input-custom:focus {
    border-color: #007bff;
    /* Focus border color */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Focus shadow */
}

.dark-mode h2 {
    color: #f7f9fc;
    /* Label text color */
}

.dark-mode label {
    color: #f7f9fc;
    /* Label text color */
}

.dark-mode .btn-primary {
    background-color: #007bff;
    /* Button background color */
    border-color: #007bff;
    /* Button border color */
}

.dark-mode .btn-primary:hover {
    background-color: #0056b3;
    /* Button hover color */
    border-color: #0056b3;
    /* Button border hover color */
}
</style>