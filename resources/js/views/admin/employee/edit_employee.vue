<template>
  <div class="edit-employee">
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
          <h6 class="m-0 font-weight-bold text-primary">Edit Employee</h6>
        </div>
        <div class="card-body">
          <form @submit.prevent="updateEmployee" enctype="multipart/form-data">
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
                    :src="displayPhoto"
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
              <button type="submit" class="btn btn-primary btn-md">
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AppStorage from "../../../helper/app_storage";

export default {
  props: ["id"],
  data() {
    return {
      displayPhoto: null,
      form: [],
      errors: [],
    };
  },
  created() {
    this.getEmployee();
  },
  methods: {
    getEmployee() {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/edit/employee/${this.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.form = res.data.employee;
            if(this.form.photo){
                this.displayPhoto = "http://127.0.0.1:8000/" + this.form.photo
                delete this.form.photo
            }
           
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
          console.log(error);
        });
    },
    // show image reactively when image selected
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 2048770) {
        Notification.error("Image should not exceed more than 2MB");
      } else {
        this.photoChange = true;
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.photo = event.target.result;
          this.displayPhoto = this.form.photo
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    updateEmployee(){
   
       let token = AppStorage.getToken()
        delete this.form.id
         console.log(this.form)
      axios
        .post(`${CONSTS.API_URL}admin/update/employee/${this.id}`, this.form, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Toast.fire({
              icon: "success",
              title: "Employee Successfully Updated",
            });
            this.$router.push({ name : 'AllEmployee' })
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
            console.log(error.response)
          }
          console.log(error.message);
        });
    }
  },
};
</script>
    
<style>
</style>