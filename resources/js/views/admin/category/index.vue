<template>
  <div class="all category">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <CreateCategory @getAllCategories="getAllCategories" />
        <EditCategory @getAllCategories="getAllCategories" ref="editCat" />
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            placeholder="category's name"
            aria-label="category's name"
            aria-describedby="basic-addon2"
            v-model="key"
          />
          <div class="input-group-append">
            <button
              @click="search"
              class="btn btn-outline-primary"
              type="button"
            >
              Search
            </button>
          </div>
        </div>
        <div class="card">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">category Tables</h6>
          </div>

          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Category Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="category in categories.data" :key="category.id">
                  <td>{{ category.id }}</td>
                  <td>{{ category.category_name }}</td>
                  <td style="white-space: nowrap">
                      <button @click="showModal(category)" class="btn btn-primary btn-sm">
                        <i class="far fa-fw fa-edit"></i>
                      </button>
                    <button
                      @click="deleteCategory(category.id)"
                      class="btn btn-danger btn-sm"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination
              :limit="1"
              size="small"
              align="right"
              :data="categories"
              @pagination-change-page="getAllCategories"
            >
              <span slot="prev-nav">&lt; Previous</span>
              <span slot="next-nav">Next &gt;</span>
            </pagination>
          </div>
        </div>
      </div>
    </div>
    <!--Row-->
  </div>
</template>

<script>
import axios from "axios";
import User from "../../../helper/user";
import AppStorage from "../../../helper/app_storage.js";
import pagination from "laravel-vue-pagination";
import CreateCategory from "../category/create.vue"
import EditCategory from "../category/edit.vue"

export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "Login" });
    } else {
      this.getAllCategories();
    }
  },
  components: {
    pagination,
    CreateCategory,
    EditCategory,
  },
  data() {
    return {
      categories: {},
      category_name : '',
      key: "",
    };
  },
  methods: {
    search(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/category/all?q=${this.key}&page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.categories = res.data.collection;
            console.log(res.data);
          } else {
            Toast.fire({
              icon: "error",
              title: "Invalid Token or Token is Expire Please re-login",
            });
            AppStorage.clear();
            this.$router.push({ name: "Login" });
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          console.log(error);
        });
    },
    deleteCategory(id) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/category/delete/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.getAllCategories();
            Toast.fire({
              icon: "success",
              title: `${res.data.message}`,
            });
          } else {
            Toast.fire({
              icon: "error",
              title: "Invalid Token or Token is Expire Please re-login",
            });
            AppStorage.clear();
            this.$router.push({ name: "Login" });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getAllCategories(page = 1) {
      console.log('working emitted getAllCat')
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/category/all?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.categories = res.data.collection;
          } else {
            Toast.fire({
              icon: "error",
              title: "Invalid Token or Token is Expire Please re-login",
            });
            AppStorage.clear();
            this.$router.push({ name: "Login" });
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          console.log(error);
        });
    },
    showModal(category){
      this.$refs.editCat.showModal(category);
    }
  },
};
</script>

<style scoped>
.pagination {
  margin-bottom: 0;
}
</style>