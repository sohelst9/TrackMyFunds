<template>
    <!-- Cards Section -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Product</h5>
                    <p class="card-text">50</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">All Category</h5>
                    <p class="card-text">1200</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Sale</h5>
                    <p class="card-text">25,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">New Messages</h5>
                    <p class="card-text">15</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Table -->
    <div class="mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Statistics</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Soccer and Spikes</td>
                            <td>450</td>
                            <td>450</td>
                            <td><button class="btn btn-sm btn-primary">View</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Car Racing 3D</td>
                            <td>300</td>
                            <td>300</td>
                            <td><button class="btn btn-sm btn-primary">View</button></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Platformer Hero</td>
                            <td>150</td>
                            <td>150</td>
                            <td><button class="btn btn-sm btn-primary">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
</script>