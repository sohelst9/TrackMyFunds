<template>
    <div class="mt-4">
        <div class="custom-card shadow-sm border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center">
                <h4>New Product</h4>
                <router-link class="btn custom-btn-light btn-sm" :to="{ name: 'admin_products' }">Back</router-link>
            </div>
            <hr>
            <div class="card-body">
                <form id="gameForm" @submit.prevent="ProductFormData">
                    <div class="row">
                        <!-- Product Details Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="p_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control custom-input" v-model="ProductData.name" id="p_name">
                            </div>

                            <div class="mb-3">
                                <label for="pCategory" class="form-label">Product Category</label>
                                <select class="form-select custom-select" id="pCategory" v-model="ProductData.category">
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="organic-fruits">Organic Fruits</option>
                                    <option value="organic-vegetables">Organic Vegetables</option>
                                    <option value="organic-grains">Organic Grains</option>
                                    <option value="organic-dairy">Organic Dairy Products</option>
                                    <option value="organic-meat">Organic Meat & Poultry</option>
                                    <option value="organic-beverages">Organic Beverages</option>
                                    <option value="organic-snacks">Organic Snacks</option>
                                    <option value="organic-beauty">Organic Beauty & Personal Care</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input type="number" class="form-control custom-input" id="productPrice"
                                    name="productPrice" placeholder="Enter product price" step="0.01" v-model="ProductData.price">
                            </div>

                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control custom-input" id="productStock"
                                    name="productStock" placeholder="Enter stock quantity" v-model="ProductData.quantity">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control custom-textarea" id="description" v-model="ProductData.description"
                                    rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Additional Information Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productSize" class="form-label">Product Size</label>
                                <input type="text" class="form-control custom-input" id="productSize" v-model="ProductData.size"
                                    placeholder="Enter size (e.g., 250g, 1L)">
                            </div>

                            <div class="mb-3">
                                <label for="productWeight" class="form-label">Product Weight</label>
                                <input type="text" class="form-control custom-input" id="productWeight" v-model="ProductData.weight" placeholder="Enter weight (e.g., 500g)">
                            </div>

                            <div class="mb-3">
                                <label for="packagingType" class="form-label">Packaging Type</label>
                                <select class="form-select custom-select" id="packagingType" v-model="ProductData.packageType">
                                    <option value="" disabled selected>Select Packaging Type</option>
                                    <option value="bottle">Bottle</option>
                                    <option value="box">Box</option>
                                    <option value="bag">Bag</option>
                                    <option value="jar">Jar</option>
                                    <option value="bulk">Bulk</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="gameImage" class="form-label">Upload Game Image</label>
                                <input type="file" class="form-control custom-input" id="gameImage" @change="GetImage"
                                    accept="image/*">
                            </div>

                            <div class="mb-3" id="imagePreviewContainer">
                                <img id="customImagePreview" v-if="PreviewImage" :src="PreviewImage"
                                    class="img-fluid rounded shadow" alt="Image Preview">
                            </div>

                            <!-- Meta Information -->
                            <div class="mb-3">
                                <label for="seoTitle" class="form-label">SEO Title</label>
                                <input type="text" class="form-control custom-input" id="seoTitle" v-model="ProductData.meta_title"
                                    placeholder="Enter SEO title for the product">
                            </div>

                            <div class="mb-3">
                                <label for="seoDescription" class="form-label">SEO Description</label>
                                <textarea class="form-control custom-input" id="seoDescription" v-model="ProductData.meta_description"
                                    rows="3" placeholder="Enter SEO description for the product"></textarea>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isFeatured" v-model="ProductData.isFeatured">
                                <label class="form-check-label" for="isFeatured">Is Featured</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn custom-btn-gradient">Add Game</button>
                </form>
            </div>
        </div>
    </div>
</template>


<script setup>
import { reactive, ref } from 'vue';

const PreviewImage = ref(null);
const ProductData = reactive({
    name:'',
    category:'',
    price:'',
    quantity: '',
    description: '',
    size:'',
    weight: '',
    packageType: '',
    product_image: '',
    meta_title: '',
    meta_description: '',
    isFeatured: ''
});
const GetImage = (e) => {
    const image = e.target.files[0];
    ProductData.product_image = image;
    PreviewImage.value = URL.createObjectURL(image);
}

const ProductFormData = () => {
    console.log(ProductData)
}
</script>
