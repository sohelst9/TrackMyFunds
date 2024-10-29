<template>
    <!-- Add Transaction Content -->
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Add Transaction</h3>
                <a href="#" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form @submit.prevent="AddtrnxSubmit">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" v-model="addData.type">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" v-model="addData.date">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" v-model="addData.description">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" v-model="addData.amount">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref, reactive } from 'vue'

// add trnx data use reactive
const addData = reactive({
    type: '',
    date: '',
    description: '',
    amount: ''
});

// add trnx submit
const AddtrnxSubmit = () => {
    console.log(addData);
    resetData();
}

// reset data after trnx submit successfully
const resetData = () => {
    addData.type = '';
    addData.date = '';
    addData.description = '';
    addData.amount = '';
}
</script>