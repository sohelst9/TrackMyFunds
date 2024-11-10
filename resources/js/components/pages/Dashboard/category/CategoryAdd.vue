<template>
    <div class="mt-4">
        <div class="custom-card shadow-sm border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center">
                <h4>New Category</h4>
                <router-link class="btn custom-btn-light btn-sm" :to="{ name: 'admin_products' }">Back</router-link>
            </div>
            <hr>
            <div class="card-body">
                <form id="gameForm" @submit.prevent="CategoryFormData">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <div class="mb-3">
                                <label for="c_name" class="form-label">Category Name</label>
                                <input type="text" v-model="categories.name" class="form-control custom-input" id="c_name">
                                <p class="error_message" v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" @change="ImageChange" class="form-control custom-input" id="image">
                                <p class="error_message" v-if="errors.image">{{ errors.image[0] }}</p>
                            </div>

                            <div class="mb-3" id="imagePreviewContainer">
                                <img id="customImagePreview" v-if="PreviewcateImage" :src="PreviewcateImage"
                                    class="img-fluid rounded shadow" alt="Image Preview">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control custom-textarea" v-model="categories.description" id="description" rows="4"></textarea>
                                <p class="error_message" v-if="errors.description">{{ errors.description[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control custom-input" v-model="categories.meta_title" id="meta_title">
                            </div>

                            <div class="mb-3">
                                <label for="metadescription" class="form-label">Meta Description</label>
                                <textarea class="form-control custom-textarea" v-model="categories.meta_description" id="metadescription" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn custom-btn-gradient">Add Category</button>

                        </div>
                    </div>
                    
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

const PreviewcateImage = ref(null);
const errors = reactive({});
const toast = useToast();
const router =useRouter();

const categories = reactive({
    name: '',
    description: '',
    image: null,
    meta_title: '',
    meta_description: ''
});

const ImageChange = (e) => {
    const Targetimage = e.target.files[0];
    categories.image = Targetimage;
    PreviewcateImage.value = URL.createObjectURL(Targetimage)
}

const CategoryFormData =async () => {
    try{
        Object.keys(errors).forEach(key => delete errors[key]);
        const response = await axios.post('/category', categories, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    if(response.data.status === 200){
        toast.success(response.data.message);
        router.push({name: 'admin_categories'})
    }else if (response.data.status === 422){
        Object.assign(errors, response.data.errors);
    }
    }catch(err){
        toast.error("Something went wrong. Please try again later.");
    }
}

</script>


<style scoped>
.error_message {
    font-weight: bold;
    font-style: italic;
    color: rgb(131, 11, 11);
    margin-top: 3px;
}
</style>