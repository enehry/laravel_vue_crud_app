<template>
  <div class="create_category_modal">
    <button
      type="button"
      class="btn btn-primary mb-4"
      data-toggle="modal"
      data-target="#createCategoryModal"
      data-whatever="@getbootstrap"
    >
      Add Category
    </button>

    <div
      class="modal fade"
      id="createCategoryModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Create New Category
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <label for="message-text" class="col-form-label"
                  >Category Name :</label
                >
                <input type="text" class="form-control" v-model="category_name" />
                <small v-if="errors" class="text-danger">
                    {{ errors.category_name.join() }}
                </small>
              </div>
            
          </div>
          <div class="modal-footer">
            <button
            @click="clear"
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button @click="saveCategory" type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import AppStorage from '../../../helper/app_storage'
import $ from 'jquery'

export default {
    props : ['getAllCategories'],
    data(){
        return {
            category_name : '',
            errors : null
        }
    },
    methods: {
    saveCategory() {
      console.log(this.category_name);

      let token = AppStorage.getToken()

      axios
        .post(`${CONSTS.API_URL}admin/category/create`, { 'category_name' : this.category_name }, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Toast.fire({
              icon: "success",
              title: "Category Successfully Added",
            });
            console.log(data)
            this.clear()
             $('#createCategoryModal').modal('hide')
            this.$emit('getAllCategories')

          } else {
            Toast.fire({
              icon: "error",
              title: "Invalid Token or Token is Expire Please re-login",
            });
            app_storage.clear();
            this.$router.push({ name: "Login" });
          }
        })
        .catch((error) => {
          if(error.response.status == 422){
            this.errors = error.response.data.errors
          }
          console.log(error);
        });
    },
    clear(){
        this.errors = null
        this.category_name = ''
    }
    },

    
}
</script>

<style>

</style>