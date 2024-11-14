<template>
    <div class="mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>All Sales</h4>
                <input type="text" placeholder="Search sale..." class="form-control me-2" style="max-width: 300px;">
                <router-link :to="{name: 'admin_sale_add'}" class="btn btn-sm btn-primary">New Sale</router-link>
            </div>
            <div class="card-body">
                <!-- Loading and Error Message -->
                <div class="text-center text-danger">Error message goes here</div>

                <!-- Sale List Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Static Sale Data Example -->
                        <tr>
                            <td>1</td>
                            <td>INV-001</td>
                            <td>John Doe</td>
                            <td>2024-11-13</td>
                            <td>$500.00</td>
                            <td>$300.00</td>
                            <td>$200.00</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary me-2">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>INV-002</td>
                            <td>Jane Smith</td>
                            <td>2024-11-12</td>
                            <td>$700.00</td>
                            <td>$700.00</td>
                            <td>$0.00</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary me-2">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="disabled">
                        <i class="fa fa-chevron-left"></i>
                    </button>
                    <button class="active">1</button>
                    <button>
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
