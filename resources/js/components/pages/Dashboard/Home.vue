<template>
    <!-- Cards Section -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Product</h5>
                    <p class="card-text">{{ totalProducts ? totalProducts : 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">All Category</h5>
                    <p class="card-text">{{ totalcategories ? totalcategories: 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ usersTotal ? usersTotal: 0 }}</p>
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
                <p class="text-center" v-if="dataNotFound">{{ dataNotFound }}</p>
                <table class="table table-striped" v-else>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr v-for="(Product, index) in Products" :key="Product.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ Product.name }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm">{{ Product.category ? Product.category.name : null }}</a>
                            </td>
                            <td>
                                <img :src="ProductImage(Product.product_image)" width="100" class="rounded-custom">
                            </td>
                            <td>{{ Product.price }}</td>
                            <td>{{ Product.stock_quantity }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useToast } from "vue-toastification";


const Products = ref([]);
const totalProducts = ref(null);
const totalcategories = ref(null);
const usersTotal = ref(null);
const toast = useToast();
const dataNotFound = ref(null);

//--ProductImage
const ProductImage = (Image) => {
    return `storage/${Image}`
}

const getProducts = async () => {
    try {
        const response = await axios.get('/dashboard_overview');
        totalProducts.value = response.data.totalProducts;
        usersTotal.value = response.data.usersTotal;
        totalcategories.value = response.data.totalcategories;
        if (response.data.products.length > 0) {
            Products.value = response.data.products;
        } else {
            dataNotFound.value = "Data Not Found";
        }
    } catch (error) {
        toast.error("Something went wrong. Please try again later.");
    }
}

onMounted(() => {
    getProducts();
})
</script>

<style scoped>
.rounded-custom {
    border-radius: 20px;
    width: 100px;
    height: 100px;
    object-fit: cover;
}
</style>