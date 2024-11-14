<template>
    <div class="mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>All Sales</h4>
                <router-link :to="{ name: 'admin_sale_add' }" class="btn btn-sm btn-primary">New Sale</router-link>
            </div>
            <div class="card-body">
                <!-- Loading and Error Message -->
                <div v-if="error" class="text-center text-danger">{{ error }}</div>
                <div v-if="loading" class="text-center">Loading..</div>

                <!-- Sale List Table -->
                <table class="table table-striped" v-else>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sale, index) in sales" :key="sale.id">
                            <td>{{ index+1 }}</td>
                            <td>{{ sale.InvoiceNumber }}</td>
                            <td>{{ sale.customerName }}</td>
                            <td>{{ sale.InvoiceDate }}</td>
                            <td>{{ sale.SaleQunatity }}</td>
                            <td>{{ sale.InvoiceTotal }}</td>
                            <td>{{ sale.InvoicePaid }}</td>
                            <td>{{ sale.InvoiceDue }}</td>
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

const sales = ref([]);
const error = ref(null);
const loading = ref(true);

const GetSales = async () => {
    try {
        const response = await axios.get('/sales');
        if(response.data.length > 0){
            sales.value = response.data;
            loading.value = false;
        }else{
            error.value = 'No Sale Data Found';
            loading.value = false;
        }
        
    } catch (err) {
        console.log(err);
        loading.value = false;
    }
}

onMounted(() => {
    GetSales();
});

</script>
