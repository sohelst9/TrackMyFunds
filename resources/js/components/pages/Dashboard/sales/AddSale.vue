<template>
    <div class="mt-4">
        <div class="custom-card shadow-sm border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center">
                <h4>New Sale</h4>
                <router-link class="btn custom-btn-light btn-sm" :to="{ name: 'admin_sales' }">Back</router-link>
            </div>
            <hr>
            <div class="card-body">
                <form id="saleForm" @submit.prevent="SaleDataSubmit">
                    <!-- Customer Information Section -->
                    <div class="section mb-4">
                        <h5 class="section-title">Customer Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customerName" class="form-label">Customer Name</label>
                                <input type="text" class="form-control custom-input" v-model="SaleInfo.customerName" id="customerName" placeholder="Enter customer name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customerPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control custom-input" v-model="SaleInfo.customerPhone" id="customerPhone" placeholder="Enter phone number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control custom-input" v-model="SaleInfo.customerCompany" id="companyName" placeholder="Enter company name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customerAddress" class="form-label">Address</label>
                                <input type="text" class="form-control custom-input" v-model="SaleInfo.customerAddress" id="customerAddress" placeholder="Enter address">
                            </div>
                        </div>
                    </div>

                    <!-- Product Information Section -->
                    <div class="section mb-4">
                        <h5 class="section-title">Product Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productSelect" class="form-label">Product</label>
                                <select class="form-select custom-select" v-model="SaleInfo.Product_id" id="productSelect">
                                    <option value="" disabled selected>Select Product</option>
                                    <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="salePrice" class="form-label">Sale Price</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.ProductSalePrice" id="salePrice" placeholder="Enter sale price" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stockQuantity" class="form-label">Stock</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.ProductStock" id="stockQuantity" placeholder="Available stock" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="addQuantity" class="form-label">Add Quantity</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.SaleQunatity" id="addQuantity" placeholder="Enter quantity to add">
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Information Section -->
                    <div class="section mb-4">
                        <h5 class="section-title">Invoice Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="invoiceNumber" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control custom-input" v-model="SaleInfo.InvoiceNumber" id="invoiceNumber" placeholder="Enter invoice number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="invoiceDate" class="form-label">Date</label>
                                <input type="date" class="form-control custom-input" v-model="SaleInfo.InvoiceDate" id="invoiceDate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="totalAmount" class="form-label">Total</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.InvoiceTotal" id="totalAmount" placeholder="Total amount" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="paidAmount" class="form-label">Paid</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.InvoicePaid" id="paidAmount" placeholder="Amount paid" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dueAmount" class="form-label">Due</label>
                                <input type="number" class="form-control custom-input" v-model="SaleInfo.InvoiceDue" id="dueAmount" placeholder="Due amount" step="0.01">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn custom-btn-gradient">Submit Sale</button>
                </form>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';

const products = ref([]);
const SaleInfo = reactive({
    customerName:'',
    customerPhone:'',
    customerCompany:'',
    customerAddress:'',
    Product_id:'',
    ProductCategory:'',
    ProductSalePrice:'',
    ProductStock:'',
    SaleQunatity:'',
    InvoiceNumber:'',
    InvoiceDate:'',
    InvoiceTotal:'',
    InvoicePaid:'',
    InvoiceDue:'',
});

//-- get products
const getProducts = async () => {
    const response = await axios.get('/get/products');
    products.value = response.data;
}
//--SaleDataSubmit
const SaleDataSubmit = async () => {
    const response = 'dd';
    console.log(response)
}

onMounted(() => {
    getProducts();
})
</script>
