<template>
  <div class="create-employee">
    <div>
      <!-- Form Basic -->
      <div class="card mb-4">
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
          <h6 class="m-0 font-weight-bold text-primary">Add Employee</h6>
        </div>
        <div class="card-body">
          <form @submit.prevent="saveEmployee" enctype="multipart/form-data">
            <div class="form-group">
              <label for="">Full Name</label>
              <input
                v-model="form.name"
                type="text"
                class="form-control"
                id="inputFullName"
                placeholder="Enter Full Name"
              />
              <small class="text-danger" v-if="errors.name">
                {{ errors.name.join() }}
              </small>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    placeholder="Enter email"
                  />
                  <small id="emailHelp" class="form-text text-muted"
                    >We'll never share your email with anyone else.</small
                  >
                  <small class="text-danger" v-if="errors.email">
                    {{ errors.email.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Phone Number</label>
                  <input
                    v-model="form.phone"
                    type="text"
                    class="form-control"
                    id="inputPhoneNumber"
                    placeholder="Enter Phone Number"
                  />
                  <small class="text-danger" v-if="errors.phone">
                    {{ errors.phone.join() }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Salary</label>
                  <input
                    v-model="form.salary"
                    type="text"
                    class="form-control"
                    id="inputSalary"
                    placeholder="Enter Salary"
                  />
                  <small class="text-danger" v-if="errors.salary">
                    {{ errors.salary.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">NID</label>
                  <input
                    v-model="form.nid"
                    type="text"
                    class="form-control"
                    id="inputNID"
                    placeholder="Enter NID"
                  />
                  <small class="text-danger" v-if="errors.nid">
                    {{ errors.nid.join() }}
                  </small>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="">Full Address</label>
              <input
                v-model="form.address"
                type="text"
                class="form-control"
                id="inputFullAddress"
                placeholder="Enter Full Address"
              />
              <small class="text-danger" v-if="errors.name">
                {{ errors.address.join() }}
              </small>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Joining Date</label>
                  <input
                    v-model="form.joining_date"
                    type="date"
                    class="form-control"
                    id="inputDate"
                  />
                  <small class="text-danger" v-if="errors.joining_date">
                    {{ errors.joining_date.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between">
                  <img
                    :src="form.photo"
                    style="height: 80px; width: 80px"
                    alt=""
                  />
                  <div class="form-group">
                    <label for=""> Photo</label>
                    <div class="custom-file">
                      <input
                        type="file"
                        class="custom-file-input"
                        id="customFile"
                        @change="onFileSelected"
                      />
                      <label class="custom-file-label" for="customFile"
                        >Choose file for Photo</label
                      >
                      <small class="text-danger" v-if="errors.photo">
                        {{ errors.photo.join() }}
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr />
            <div class="float-right">
              <button type="submit" class="btn btn-primary btn-md">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../../../helper/user";
import Notification from "../../../helper/notification";
import constant from "../../../constants";
import AppStorage from "../../../helper/app_storage";
import app_storage from "../../../helper/app_storage";

export default {
  props : {
    isUpdating : false,
    employeeData : [],
  },
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "Login" });
    }
    if(this.isUpdating){
      console.log(this.isUpdating)
      console.log(this.employeeData)
    } else {
      
    }
  },
  data() {
    return {
      form: {
        name: null,
        email: null,
        phone: null,
        salary: null,
        address: null,
        photo: null,
        nid: null,
        joining_date: null,
      },
      errors: {},
    };
  },
  methods: {
    saveEmployee(event) {
      console.log(this.form);

      let token = AppStorage.getToken()

      axios
        .post(`${constant.API_URL}admin/create/employee`, this.form, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Toast.fire({
              icon: "success",
              title: "Employee Successfully Added",
            });

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
    // show image reactively when image selected
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 2048770) {
        Notification.error("Image should not exceed more than 2MB");
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.photo = event.target.result;
          console.log(event.target.result)
        };
        reader.readAsDataURL(file);
      }
    },
  },
};
</script>

<style>
</style>