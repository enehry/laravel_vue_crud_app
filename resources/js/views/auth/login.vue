<template>
  <div class="login">
    <!-- Login Content -->
    <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user" @submit.prevent="login">
                    <div class="form-group">
                      <input
                        v-model="form.email"
                        type="email"
                        class="form-control"
                        aria-describedby="emailHelp"
                        placeholder="Email Address"
                      />
                      <small class="text-danger"
                      v-if="errors.email"
                      >{{ errors.email.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <input
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        placeholder="Password"
                      />
                      <small class="text-danger"
                      v-if="errors.password"
                      >{{ errors.password.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <div
                        class="custom-control custom-checkbox small"
                        style="line-height: 1.5rem"
                      >
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          id="customCheck"
                          v-model="remember_me"
                          @click="remember"
                        />
                        <label class="custom-control-label" for="customCheck"
                          >Remember Me</label
                        >
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary btn-block">Login</button>
                    </div>
                  </form>
                  <hr />
                  <div class="text-center">
                    <router-link
                      :to="{ name: 'Register' }"
                      class="font-weight-bold small"
                      >Create an Account!</router-link
                    >
                  </div>
                  <div class="text-center">
                    <router-link
                      :to="{ name: 'Forget' }"
                      class="font-weight-bold small"
                      >Forget Password?</router-link
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- Login Content -->
</template>
<script>
import axios from "axios";
import constant from "../../constants.js";
import User from "../../helper/user";
import AppStorage from "../../helper/app_storage"

export default {
  created() {
    if (User.loggedIn()) {
      this.$router.push({ name: "Home" });
    }
    let email = AppStorage.getEmail()
    let password = AppStorage.getPassword()

    if(email && password){
      this.remember_me = true
      this.form.email = email
      this.form.password = password
    }
  },
  data() {
    return {
      form: {
        email: null,
        password: null,
      },
      errors: {
        
      },
      remember_me : false,
    };
  },
  methods: {
    remember(){
      AppStorage.clearLogin()
    },
    login() {
      axios
        .post(`${constant.API_URL}auth/login`, this.form)
        .then((res) => {
          User.responseAfterLogin(res);
          if (User.loggedIn()) {
            if(this.remember_me){
              AppStorage.storeLogin(this.form.email, this.form.password)
            }
            Toast.fire({
              icon: "success",
              title: "Signed in successfully",
            });
            this.$router.push({ name: "Home" });
          }
        })
        .catch((error) => {  
          if(error.response.status == 401){
            Toast.fire({
              icon : "warning",
              title : `${error.response.data.errors}`
            })
          } else if(error.response.status == 422){
            this.errors = error.response.data.errors
          } else {
              Toast.fire({
              icon : "error",
              title : `${error.response}`
            })
          }
        })
    },
  },
};
</script>

<style>
</style>