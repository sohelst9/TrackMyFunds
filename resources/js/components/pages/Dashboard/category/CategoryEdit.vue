<template>
    <div class="mt-4">
        <div class="custom-card shadow-sm border-0">
            <div class="custom-card-header d-flex justify-content-between align-items-center">
                <h4>New Category</h4>
                <router-link class="btn custom-btn-light btn-sm" :to="{ name: 'admin_categories' }">Back</router-link>
            </div>
            <hr>
            <div class="card-body">
                <form id="gameForm" @submit.prevent="CategoryFormDataUpdate" v-if="categories">
                    <div class="row">
                        <div class="col-md-10 m-auto">
                            <div class="mb-3">
                                <label for="c_name" class="form-label">Category Name</label>
                                <input type="text" v-model="categories.name" class="form-control custom-input"
                                    id="c_name">
                                <p class="error_message" v-if="errors.name">{{ errors.name[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" @change="IamgeChange" class="form-control custom-input" id="image">
                                <p class="error_message" v-if="errors.image">{{ errors.image[0] }}</p>
                            </div>

                            <div class="mb-3" id="imagePreviewContainer">
                                <img id="customImagePreview" v-if="PreviewcateImage" :src="PreviewcateImage"
                                    class="img-fluid rounded shadow" alt="Image Preview">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control custom-textarea" v-model="categories.description"
                                    id="description" rows="4"></textarea>
                                <p class="error_message" v-if="errors.description">{{ errors.description[0] }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control custom-input" v-model="categories.meta_title"
                                    id="meta_title">
                            </div>

                            <div class="mb-3">
                                <label for="metadescription" class="form-label">Meta Description</label>
                                <textarea class="form-control custom-textarea" v-model="categories.meta_description"
                                    id="metadescription" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn custom-btn-gradient">Update Category</button>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';


const props = defineProps({
    slug: {
        type: String,
        Required: true
    }
})

const toast = useToast();
const router = useRouter();
const categories = ref(null);
const errors = reactive({});
const PreviewcateImage = ref(null);



const getCategoryData = async () => {
    const response = await axios.get(`/category/${props.slug}`);
    if (response.data.status === 404) {
        router.push({ name: 'admin_categories' });
        toast.error(response.data.message);
    } else {
        categories.value = response.data.data;
        PreviewcateImage.value = response.data.data.image;

    }

}


onMounted(() => {
    getCategoryData()
})

//--update code

const IamgeChange = (e) => {
    const file = e.target.files[0];
    categories.value.image = file;
    PreviewcateImage.value = URL.createObjectURL(file);

}

const CategoryFormDataUpdate = async () => {
    try {
        Object.keys(errors).forEach(key => delete errors[key]);
        const categoryUpdateData = new FormData();
        categoryUpdateData.append('_method', 'PATCH');
        categoryUpdateData.append('name', categories.value.name);
        categoryUpdateData.append('description', categories.value.description);
        categoryUpdateData.append('meta_title', categories.value.meta_title);
        categoryUpdateData.append('meta_description', categories.value.meta_description);
        if(categories.value.image instanceof File){
            categoryUpdateData.append('image', categories.value.image);
        }

        const response = await axios.post(`/category/${categories.value.slug}`, categoryUpdateData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        if (response.data.status === 200) {
            toast.success(response.data.message);
            router.push({name: 'admin_categories'});
        } else if (response.data.status === 422) {
            Object.assign(errors, response.data.errors)
        }
    } catch (error) {
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