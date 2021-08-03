<template>
  <div class="all employee">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <router-link :to="{ name: 'CreateEmployee' }">
          <button class="btn btn-primary mb-4">Add Employee</button>
        </router-link>
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control"
            placeholder="Employee's name"
            aria-label="Employee's name"
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
            <h6 class="m-0 font-weight-bold text-primary">Employee Tables</h6>
          </div>

          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Employee Name</th>
                  <th>Phone</th>
                  <th>Salary</th>
                  <th>Address</th>
                  <th >Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees.data" :key="employee.id">
                  <td>{{ employee.id }}</td>
                  <td>
                    <span v-if="employee.photo">
                      <img
                        class="rounded-circle"
                        height="40"
                        width="40"
                        :src="employee.photo"
                        alt=""
                      />
                    </span>
                  </td>
                  <td>{{ employee.name }}</td>
                  <td>{{ employee.phone }}</td>
                  <td>{{ employee.salary }}</td>
                  <td>{{ employee.address }}</td>
                  <td style="white-space: nowrap;">
                    <router-link :to="{ name : 'EditEmployee', params : { id : employee.id } }">
                      <button class="btn btn-primary btn-sm"><i class="far fa-fw fa-edit"></i></button>
                    </router-link>
                    
                    <button
                      @click="deleteEmployee(employee.id)"
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
              :data="employees"
              @pagination-change-page="getAllEmployees"
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
      this.getAllEmployees();
    }
  },
  components: {
    pagination,
  },
  data() {
    return {
      employees: {},
      key: "",
    };
  },
  methods: {
    search(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/all/employee?q=${this.key}&page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.employees = res.data.collection;
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
      console.log("asdasd");
    },
    deleteEmployee(id) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/delete/employee/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.getAllEmployees();
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
          // if (error.response.status == 422) {
          //   this.errors = error.response.data.errors;
          // }
          console.log(error);
        });
    },
    getAllEmployees(page = 1) {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/all/employee?page=${page}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.employees = res.data.collection;
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
    editEmp(employeeData){
    console.log(employeeData)
    this.$router.push({ name : 'CreateEmployee', params : { employee : employeeData, isUpdating : true, }})
  }
  },
  
};
</script>

<style scoped>
.pagination {
  margin-bottom: 0;
}
</style>