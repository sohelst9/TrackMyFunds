<template>
    <div class="mt-4">
        <div class="custom-card shadow-sm border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center">
                <h4>Edit Product</h4>
                <router-link class="btn custom-btn-light btn-sm" :to="{ name: 'admin_products' }">Back</router-link>
            </div>
            <hr>
            <div class="card-body">
                <form id="gameForm" @submit.prevent="ProductFormData" v-if="ProductData">
                    <div class="row">
                        <!-- Product Details Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="p_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control custom-input" v-model="ProductData.name"
                                    id="p_name">
                                <p class="text-danger mt-1 error_message" v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="pCategory" class="form-label">Product Category</label>
                                <select class="form-select custom-select" id="pCategory"
                                    v-model="ProductData.category_id">
                                    <option value="" disabled selected>Select Category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>

                                </select>
                                <p class="text-danger mt-1 error_message" v-if="errors.category">{{ errors.category[0]
                                    }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input type="number" class="form-control custom-input" id="productPrice"
                                    name="productPrice" placeholder="Enter product price" step="0.01"
                                    v-model="ProductData.price">
                                <p class="text-danger mt-1 error_message" v-if="errors.price">{{ errors.price[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control custom-input" id="productStock"
                                    name="productStock" placeholder="Enter stock quantity"
                                    v-model="ProductData.quantity">
                                <p class="text-danger mt-1 error_message" v-if="errors.quantity">{{ errors.quantity[0]
                                    }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control custom-textarea" id="description"
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
                                <input type="file" class="form-control custom-input" id="gameImage" @change="GetImage"
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

                    <button type="submit" class="btn custom-btn-gradient">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { defineProps, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

//--- using props
const props = defineProps({
    slug: {
        type: String,
        Required: true
    }
});

const router = useRouter();
const toast = useToast();
const PreviewImage = ref(null);
const errors = reactive({});

//--call category data --
const categories = ref([]);
const getCategories = async () => {
    try {
       const response = await axios.get('/category');
       categories.value = response.data.data;

    } catch (error) {
        console.log('error', error);
    }
}

//--- using ref and store product data
const ProductData = ref(null);



//-- call api to get product data
const getProductData = async () => {
    const response = await axios.get(`/product/${props.slug}`);
    if (response.data.status == 404) {
        router.push({ name: 'notfound' });
        console.log(response.data.message)
    } else {
        ProductData.value = response.data.data;
        ProductData.value.isFeatured = response.data.data.isFeatured === 1; //--- integer to Boolean 
        PreviewImage.value = `/${response.data.data.product_image}`;
        // console.log(response.data.data)
    }
}

//-- call api when component is mounted
onMounted(() => {
    getProductData();
    getCategories();
})



//---update code 


//--- handle image
const GetImage = (event) => {
    const file = event.target.files[0];
    ProductData.value.product_image = file;
    PreviewImage.value = URL.createObjectURL(file);
}

//-- handle form submit 
const ProductFormData = async () => {
    try {
        Object.keys(errors).forEach(key => delete errors[key]);
        const formData = new FormData();
        formData.append('_method', 'PATCH');
        formData.append('name', ProductData.value.name);
        formData.append('category', ProductData.value.category_id);
        formData.append('price', ProductData.value.price);
        formData.append('quantity', ProductData.value.quantity);
        formData.append('description', ProductData.value.description);
        formData.append('size', ProductData.value.size);
        formData.append('weight', ProductData.value.weight);
        formData.append('packageType', ProductData.value.packageType);
        if (ProductData.value.product_image instanceof File) {
            formData.append('product_image', ProductData.value.product_image);
        }
        formData.append('meta_title', ProductData.value.meta_title);
        formData.append('meta_description', ProductData.value.meta_description);
        formData.append('isFeatured', ProductData.value.isFeatured ? 1 : 0);
        const response = await axios.post(`/product/${props.slug}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.status == 200) {
            router.push({ name: 'admin_products' });
            toast.success(response.data.message);
        } else if (response.data.status == 422) {
            Object.assign(errors, response.data.errors);
        }

    } catch (error) {
        toast.error("Something went wrong. Please try again later.");
    }
}
</script>