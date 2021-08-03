<template>
  <div class="all supplier">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <router-link :to="{ name: 'CreateSupplier' }">
          <button class="btn btn-primary mb-4">Add Supplier</button>
        </router-link>
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            placeholder="supplier's name"
            aria-label="supplier's name"
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
                  <th>Photo</th>
                  <th>Supplier Name</th>
                  <th>Shop Name</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th >Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="supplier in suppliers.data" :key="supplier.id">
                  <td>{{ supplier.id }}</td>
                  <td>
                    <span v-if="supplier.photo">
                      <img
                        class="rounded-circle"
                        height="40"
                        width="40"
                        :src="supplier.photo"
                        alt=""
                      />
                    </span>
                  </td>
                  <td>{{ supplier.name }}</td>
                  <td>{{ supplier.shop_name }}</td>
                  <td>{{ supplier.email }}</td>
                  <td>{{ supplier.address }}</td>
                  <td style="white-space: nowrap;">
                    <router-link :to="{ name : 'EditSupplier', params : { id : supplier.id } }">
                      <button class="btn btn-primary btn-sm"><i class="far fa-fw fa-edit"></i></button>
                    </router-link>
                    
                    <button
                      @click="deleteSupplier(supplier.id)"
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
              :data="suppliers"
              @pagination-change-page="getAllSuppliers"
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
import User from "../../../helper/user.js";
import AppStorage from "../../../helper/app_storage.js";
import pagination from "laravel-vue-pagination";

export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "Login" });
    } else {
      this.getAllSuppliers();
    }
  },
  components: {
    pagination,
  },
  data() {
    return {
      suppliers: {},
      key : ""
    };
  },
  methods: {
    search(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/supplier/all?q=${this.key}&page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.suppliers = res.data.collection;
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
    deleteSupplier(id) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/supplier/delete/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.getAllSuppliers();
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
    getAllSuppliers(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/supplier/all?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.suppliers = res.data.collection;
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
    editEmp(supplierData){
    console.log(supplierData)
    this.$router.push({ name : 'CreateSupplier', params : { supplierData }})
  }
  },
  
};
</script>

<style scoped>
.pagination {
  margin-bottom: 0;
}
</style>