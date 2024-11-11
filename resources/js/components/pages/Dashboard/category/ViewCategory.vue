<template>
    <div class="mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>All Categories</h4>
                <input v-model="search" type="text" @input="SearchProduct" placeholder="Search category..."
                    class="form-control me-2" style="max-width: 300px;">
                <router-link class="btn btn-sm btn-success" :to="{ name: 'admin_category_create' }">New
                    Category</router-link>
            </div>
            <div class="card-body">
                <div v-if="loading">Loading..</div>
                <div class="text-center text-danger" v-else-if="error">{{ error }}</div>
                <table v-else class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(category, index) in categories" :key="category.id">
                            <td>{{ (meta.current_page - 1) * meta.per_page + index + 1 }}</td>
                            <td>{{ category.name }}</td>
                            <td>
                                <img alt="" :src="category.image" width="100" class="rounded-custom">
                            </td>
                            <td>{{ category.short_desc }}</td>
                            <td>edit</td>

                            <!-- <td>
                         <router-link class="btn btn-sm btn-primary me-2"
                            :to="{ name: 'product_edit', params: { slug: product.slug } }">Edit</router-link>
                         <a class="btn btn-sm btn-danger" @click="deleteProduct(product.slug)">Delete</a>
                      </td> -->
                        </tr>
                    </tbody>
                </table>

                <div class="pagination" v-if="ShowPaginate">
                    <button :class="{ 'disabled': !links.prev }" :disabled="!links.prev"
                        @click="PaginateUrl(links.prev)"><fontawesome-icon class="icon" icon="chevron-left" /></button>
                    <button class="active">{{ meta.current_page }}</button>
                    <button :class="{ 'disabled': !links.next }" :disabled="!links.next"
                        @click="PaginateUrl(links.next)"><fontawesome-icon class="icon" icon="chevron-right" /></button>
                </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';


const categories = ref([]);
const error = ref(null);
const loading = ref(true);
const toast = useToast();
const links = ref(null);
const meta = ref(null);
const search = ref('');

const getCategory = async (url = '/category') => {
    loading.value = true
    error.value = null
    try {
        const response = await axios.get(url, {
            params: {
                search: search.value
            }
        });
        if (response.data.data.length > 0) {
            categories.value = response.data.data;
            links.value = response.data.links;
            meta.value = response.data.meta;
            console.log(response.data)
            loading.value = false
        } else {
            error.value = "Data Not Found";
            loading.value = false
        }
    } catch (err) {
        toast.error("Something went wrong. Please try again later.");
        loading.value = false
    }
}

const SearchProduct = () => {
    getCategory();
}

const PaginateUrl = async (url) => {
    if (url) {
        getCategory(url)
    }
}

onMounted(() => {
    getCategory()
})

const ShowPaginate = computed(() => {
    return meta.value && meta.value.total > meta.value.per_page;
});

</script>


<style scoped>
.rounded-custom {
    border-radius: 20px;
    width: 100px;
    height: 100px;
    object-fit: cover;
}

/* pagination style */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
}

.pagination button {
    background-color: #fff;
    color: #007bff;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    font-size: 1.1rem;
}

.pagination button i {
    font-size: 1.2rem;
}

.pagination button.active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    font-weight: bold;
}

.pagination button:hover:not(.active) {
    background-color: #f0f8ff;
    transform: scale(1.1);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
}

.pagination button:active {
    transform: scale(0.95);
}

.pagination button:disabled {
    background-color: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
    box-shadow: none;
}

.pagination .icon {
    font-size: 1.2rem;
}
</style>