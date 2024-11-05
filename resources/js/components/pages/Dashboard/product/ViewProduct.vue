<template>
   <div class="loading-container" v-if="loading">
      <div class="progress-bar" :style="{ width: progressBarWidth }"></div>
   </div>
   <div class="mt-4">
      <div class="card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Products</h4>
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
                     <th>Quantity</th>
                     <th>Stock Quantity</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>

                  <tr v-for="(product, index) in Products" :key="product.id">
                     <td>{{ index + 1 }}</td>
                     <td>{{ product.name }}</td>
                     <td>
                        <img :src="ImagePath(product.product_image)" alt="" width="100" class="rounded-custom">
                     </td>
                     <td>
                        <a class="btn btn-sm btn-primary">{{ getCategoryName(product.category) }}</a>
                     </td>
                     <td>{{ product.price }}</td>
                     <td>{{ product.quantity }}</td>
                     <td>{{ product.stock_quantity }}</td>

                     <td>
                        <router-link class="btn btn-sm btn-primary me-2" :to="{name: 'product_edit', params: {slug: product.slug } }">Edit</router-link>
                        <a class="btn btn-sm btn-danger">Delete</a>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';


const Products = ref([]);
const loading = ref(true);
const progressBarWidth = ref('0%');
const error = ref(null);

const categories = {
   1: "Organic Fruits",
   2: "Organic Vegetables",
   3: "Organic Grains",
   4: "Organic Dairy Products",
   5: "Organic Meat & Poultry",
   6: "Organic Beverages",
   7: "Organic Snacks",
   8: "Organic Beauty & Personal Care",
};

const getCategoryName = (categoryID) => {
   return categories[categoryID];
}

const ImagePath = (image) => {
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

const getProducts = async () => {
   const response = await axios.get('/products');
   if (response.data.data.length > 0) {
      Products.value = response.data.data;
      loading.value = false
   } else {
      error.value = "No Data Found";
   }

   // console.log(response.data.data)
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
.data_not_found_mag{
   font-size: 25px;
   font-weight: 700;
   font-family: 'Courier New', Courier, monospace;
   
}
</style>