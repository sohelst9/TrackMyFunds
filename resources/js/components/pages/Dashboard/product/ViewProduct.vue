<template>
   <div class="loading-container" v-if="loading">
      <div class="progress-bar" :style="{ width: progressBarWidth }"></div>
   </div>
   <div class="mt-4">
      <div class="card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Products</h4>
            <input v-model="search" type="text" @input="SearchProduct" placeholder="Search Products..."
               class="form-control me-2" style="max-width: 300px;">
            <router-link class="btn btn-sm btn-success" :to="{ name: 'admin_product_add' }">New Product</router-link>
         </div>
         <div class="card-body">
            <div v-if="loading">loading...</div>
            <div class="text-center text-danger data_not_found_mag" v-else-if="error">{{ error }}</div>
            <table v-else class="table table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Product Name</th>
                     <th>Image</th>
                     <th>Category</th>
                     <th>Price</th>
                     <th>Weight</th>
                     <th>Type</th>
                     <th>Stock Quantity</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>

                  <tr v-for="(product, index) in Products" :key="product.id">
                     <td>{{ (meta.current_page - 1) * meta.per_page + index + 1 }}</td>
                     <td>{{ product.name }}</td>
                     <td>
                        <img :src="ImagePath(product.product_image)" alt="" width="100" class="rounded-custom">
                     </td>
                     <td>
                        <a class="btn btn-sm btn-primary">{{ product.category_name }}</a>
                     </td>
                     <td>{{ product.price }}</td>
                     <td>{{ product.weight }}</td>
                     <td>{{ product.packageType }}</td>
                     <td>{{ product.stock_quantity }}</td>

                     <td>
                        <router-link class="btn btn-sm btn-primary me-2"
                           :to="{ name: 'product_edit', params: { slug: product.slug } }">Edit</router-link>
                        <a class="btn btn-sm btn-danger" @click="deleteProduct(product.slug)">Delete</a>
                     </td>
                  </tr>
               </tbody>
            </table>

            <div class="pagination" v-if="ShowPaginate">
               <button :class="{ 'disabled': !links.prev }" @click="PaginateUrl(links.prev)"
                  :disabled="!links.prev"><fontawesome-icon class="icon" icon="chevron-left" /></button>
               <button class="active">{{ meta.current_page }}</button>
               <button :class="{ 'desabled': !links.next }" @click="PaginateUrl(links.next)"
                  :disabled="!links.next"><fontawesome-icon class="icon" icon="chevron-right" /></button>
            </div>

         </div>
      </div>
   </div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';


const Products = ref([]);
const loading = ref(true);
const progressBarWidth = ref('0%');
const error = ref(null);
const toast = useToast();
//-- paginate and search code--
const meta = ref(null);
const links = ref(null);
const search = ref('');
//-- paginate code end--

// Function to generate the image path from a relative image name
const ImagePath = (image) => {
   // Concatenate the image path with the given image name to form the complete path
   return `/${image}`;
}


//--- add progress bar loading 

const startLoading = () => {
   let width = 0;
   const interval = setInterval(() => {
      if (width >= 100) {
         clearInterval(interval);
         loading.value = false;
      } else {
         width++;
         progressBarWidth.value = `${width}%`;
      }
   }, 10);
};

//---SearchProduct
const SearchProduct = () => {
   error.value = null; // Reset the error message before performing the search
   getProducts(); // Call getProducts when search query changes
}

const getProducts = async (url = '/products') => {
   loading.value = true; // start loading
   error.value = null; // Reset the error message when starting a new request
   try {
      // Sending a GET request to the API endpoint with a search term as a query parameter
      const response = await axios.get(url, {
         params: {
            search: search.value // pass search parameters
         }
      });
      // If data is received from the response
      if (response.data.data.length > 0) {
         Products.value = response.data.data;
         meta.value = response.data.meta;
         links.value = response.data.links;
         loading.value = false; // stop loading
         // console.log(response)
      } else {
         error.value = "No Data Found"; // Set error message if no data is found
         loading.value = false; // stop loading
      }
   } catch (error) {
      toast.error("Something went wrong. Please try again later.");
      loading.value = false; // Stop loading
   }


}

//--ShowPaginate
const ShowPaginate = computed(() => {
   return meta.value && meta.value.total > meta.value.per_page;
})

// --- paginate url 
const PaginateUrl = async (url) => {
   // Check if the url is provided
   if (url) {
      // Call the getProducts function with the given url to load the products
      getProducts(url)
   }
}

//---deleteProduct ---
const deleteProduct = async (slug) => {
   try {
      if (window.confirm("Are you sure you want to delete this item?")) {
         const response = await axios.delete(`/product/delete/${slug}`);
         if (response.status === 200) {
            toast.success(response.data.message);
            getProducts();
            console.log(response.data.message)
         } else if (response.data.status === 404) {
            toast.error(response.data.message)
         }
      } else {
         toast.error('Delete canceled.')
      }
   } catch (error) {
      toast.error("Something went wrong. Please try again later.");
   }

}


onMounted(() => {
   startLoading();
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

.loading-container {
   width: 100%;
   height: 5px;
   background-color: #f3f3f3;
   position: relative;
}

.progress-bar {
   height: 100%;
   background-color: #4caf50;
   transition: width 0.1s ease-in-out;
}

.data_not_found_mag {
   font-size: 25px;
   font-weight: 700;
   font-family: 'Courier New', Courier, monospace;

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