<template>
  <div class="all supplier">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <router-link :to="{ name: 'CreateSupplier' }">
          <button class="btn btn-primary mb-4">Add Product</button>
        </router-link>
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            placeholder="Product name"
            aria-label="Product name"
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
            <h6 class="m-0 font-weight-bold text-primary">supplier Tables</h6>
          </div>

          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Product Code</th>
                  <th>Photo</th>
                  <th>Product Name</th>
                  <th>Buying Price</th>
                  <th>Selling Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products.data" :key="product.id">
                  <td>{{ product.id }}</td>
                  <td>{{ product.product_code }}</td>
                  <td>
                    <span v-if="product.image">
                      <img
                        class="rounded-circle"
                        height="40"
                        width="40"
                        :src="product.image"
                        alt=""
                      />
                    </span>
                  </td>
                  <td>{{ product.product_name }}</td>
                  <td>{{ product.buying_price }}</td>
                  <td>{{ product.selling_price }}</td>
                  <td style="white-space: nowrap">
                    <router-link :to="{ name: 'EditProduct', params : { id : product.id } }">
                    <button class="btn btn-primary btn-sm">
                      <i class="far fa-fw fa-edit"></i>
                    </button>
                    </router-link>
                    <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm">
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
              :data="products"
              @pagination-change-page="getAllProducts"
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
import User from "../../../helper/user"
import AppStorage from "../../../helper/app_storage"
import pagination from 'laravel-vue-pagination'

export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "Login" });
    } else {
      this.getAllProducts();
    }
  },
  data(){
      return {
          products : {},
          key : '',
      }
  },
  components : {
      pagination
  },
  methods : {
      search(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/product/all?q=${this.key}&page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.products = res.data.collection;
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
    getAllProducts(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/product/all?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.products = res.data.collection;
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
    deleteProduct(id) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/product/delete/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          console.log(res.data)
          if (res.data.success) {
            this.getAllProducts();
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
  }
};
</script>

<style scoped>
</style>