<template>
   <div class="mt-4">
      <div class="card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Products</h4>
            <router-link class="btn btn-sm btn-success" :to="{ name: 'admin_product_add' }">New Product</router-link>
         </div>
         <div class="card-body">
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Product Name</th>
                     <th>Image</th>
                     <th>Category</th>
                     <th>Price</th>
                     <th>Quantity</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>

                  <tr>
                     <td>1</td>
                     <td>ff</td>
                     <td>
                        <img src="" alt="" width="100">
                     </td>
                     <td>
                        <a class="btn btn-sm btn-primary">ddd</a>
                     </td>
                     <td>ddd</td>
                     <td>20</td>

                     <td>
                        <a class="btn btn-sm btn-primary">Edit</a>
                        <a class="btn btn-sm btn-danger">Delete</a>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</template>