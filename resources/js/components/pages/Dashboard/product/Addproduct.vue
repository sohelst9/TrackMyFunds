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
                                <input @input="ClearError('name')" type="text" class="form-control custom-input"
                                    v-model="ProductData.name" id="p_name">
                                <p class="text-danger mt-1 error_message" v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="pCategory" class="form-label">Product Category</label>
                                <select @input="ClearError('category')" class="form-select custom-select" id="pCategory" v-model="ProductData.category">
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="1">Organic Fruits</option>
                                    <option value="2">Organic Vegetables</option>
                                    <option value="3">Organic Grains</option>
                                    <option value="4">Organic Dairy Products</option>
                                    <option value="5">Organic Meat & Poultry</option>
                                    <option value="6">Organic Beverages</option>
                                    <option value="7">Organic Snacks</option>
                                    <option value="8">Organic Beauty & Personal Care</option>
                                </select>
                                <p class="text-danger mt-1 error_message" v-if="errors.category">{{ errors.category[0]
                                    }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input @input="ClearError('price')" type="number" class="form-control custom-input" id="productPrice"
                                    name="productPrice" placeholder="Enter product price" step="0.01"
                                    v-model="ProductData.price">
                                <p class="text-danger mt-1 error_message" v-if="errors.price">{{ errors.price[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input @input="ClearError('quantity')" type="number" class="form-control custom-input" id="productStock"
                                    name="productStock" placeholder="Enter stock quantity"
                                    v-model="ProductData.quantity">
                                <p class="text-danger mt-1 error_message" v-if="errors.quantity">{{ errors.quantity[0]
                                    }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea @input="ClearError('description')" class="form-control custom-textarea" id="description"
                                    v-model="ProductData.description" rows="4"></textarea>
                                <p class="text-danger mt-1 error_message" v-if="errors.description">{{
                                    errors.description[0] }}</p>
                            </div>
                        </div>

                        <!-- Additional Information Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productSize" class="form-label">Product Size</label>
                                <input type="text" class="form-control custom-input" id="productSize"
                                    v-model="ProductData.size" placeholder="Enter size (e.g., 250g, 1L)">
                                <p class="text-danger mt-1 error_message" v-if="errors.size">{{ errors.size[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="productWeight" class="form-label">Product Weight</label>
                                <input type="text" class="form-control custom-input" id="productWeight"
                                    v-model="ProductData.weight" placeholder="Enter weight (e.g., 500g)">
                                <p class="text-danger mt-1 error_message" v-if="errors.weight">{{ errors.weight[0] }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="packagingType" class="form-label">Packaging Type</label>
                                <select class="form-select custom-select" id="packagingType"
                                    v-model="ProductData.packageType">
                                    <option value="" disabled selected>Select Packaging Type</option>
                                    <option value="bottle">Bottle</option>
                                    <option value="box">Box</option>
                                    <option value="bag">Bag</option>
                                    <option value="jar">Jar</option>
                                    <option value="bulk">Bulk</option>
                                </select>
                                <p class="text-danger mt-1 error_message" v-if="errors.packageType">{{
                                    errors.packageType[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="gameImage" class="form-label">Upload Game Image</label>
                                <input @input="ClearError('product_image')" type="file" class="form-control custom-input" id="gameImage" @change="GetImage"
                                    accept="image/*">
                                <p class="text-danger mt-1 error_message" v-if="errors.product_image">{{
                                    errors.product_image[0] }}</p>
                            </div>

                            <div class="mb-3" id="imagePreviewContainer">
                                <img id="customImagePreview" v-if="PreviewImage" :src="PreviewImage"
                                    class="img-fluid rounded shadow" alt="Image Preview">
                            </div>

                            <!-- Meta Information -->
                            <div class="mb-3">
                                <label for="seoTitle" class="form-label">SEO Title</label>
                                <input type="text" class="form-control custom-input" id="seoTitle"
                                    v-model="ProductData.meta_title" placeholder="Enter SEO title for the product">
                                <p class="text-danger mt-1 error_message" v-if="errors.meta_title">{{
                                    errors.meta_title[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="seoDescription" class="form-label">SEO Description</label>
                                <textarea class="form-control custom-input" id="seoDescription"
                                    v-model="ProductData.meta_description" rows="3"
                                    placeholder="Enter SEO description for the product"></textarea>
                                <p class="text-danger mt-1 error_message" v-if="errors.meta_description">{{
                                    errors.meta_description[0] }}</p>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isFeatured"
                                    v-model="ProductData.isFeatured">
                                <label class="form-check-label" for="isFeatured">Is Featured</label>
                                <p class="text-danger mt-1 error_message" v-if="errors.isFeatured">{{
                                    errors.isFeatured[0] }}</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn custom-btn-gradient">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

const PreviewImage = ref(null);
const errors = reactive({});
const toast = useToast()
const router = useRouter()
const ProductData = reactive({
    name: '',
    category: '',
    price: '',
    quantity: '',
    description: '',
    size: '',
    weight: '',
    packageType: '',
    product_image: null,
    meta_title: '',
    meta_description: '',
    isFeatured: false
});
const GetImage = (e) => {
    const image = e.target.files[0];
    ProductData.product_image = image;
    PreviewImage.value = URL.createObjectURL(image);
}


//--- instant input filed clear errors
const ClearError = (field) => {
    if (errors[field]) {
        delete errors[field];
    }
}

const ProductFormData = async () => {
    try {
        ProductData.isFeatured = ProductData.isFeatured ? 1 : 0;
        // console.log(ProductData.isFeatured)
        Object.keys(errors).forEach(key => delete errors[key]);
        const response = await axios.post('/product', ProductData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        // console.log(response.data.status)
        if (response.data.status == 422) {
            Object.assign(errors, response.data.errors);
        }
        else if (response.data.status == 200) {
            // console.log(response.data.message)
            toast.success(response.data.message)
            router.push({ name: 'admin_products' })

        }
    } catch (error) {
        // console.error("An error occurred:", error);
        toast.error("Something went wrong. Please try again later.");
    }
}
</script>


<style scoped>
.error_message {
    font-weight: bold;
    font-style: italic;
}
</style>
