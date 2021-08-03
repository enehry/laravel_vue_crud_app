<template>
    <div
      class="modal fade"
      id="EditCategoryModal"
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
                <input type="text" class="form-control" v-model="category_name"/>
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
            <button @click="updateCategory" type="button" class="btn btn-primary">Save</button>
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
            category_name : null,
            id : null,
            errors : null
        }
    },
    methods: {
    updateCategory() {
      console.log(this.category_name);

      let token = AppStorage.getToken()

      axios
        .post(`${CONSTS.API_URL}admin/category/update`, {
          'category_name' : this.category_name,
          'id' : this.id
        }  , {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Toast.fire({
              icon: "success",
              title: res.data.message,
            });
            console.log(data)
            this.clear()
             $('#EditCategoryModal').modal('hide')
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
      
    },
    showModal(category){
        $('#EditCategoryModal').modal('show')
        this.category_name = category.category_name
        this.id = category.id
    }
    },

    
}
</script>

<style>

</style>