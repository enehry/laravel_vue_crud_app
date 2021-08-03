<template>
  <div class="register">
    <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form @submit.prevent="register" >
                    <div class="form-group">
                      <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        id="fullName"
                        placeholder="Full Name"
                      />
                      <small v-if="errors.name" class="text-danger">
                        {{ errors.name.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <input
                      v-model="form.email"
                        type="email"
                        class="form-control"
                        id="exampleInputEmail"
                        aria-describedby="emailHelp"
                        placeholder="Email Address"
                      />
                      <small v-if="errors.email" class="text-danger">
                        {{ errors.email.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <input
                      v-model="form.password"
                        type="password"
                        class="form-control"
                        id="exampleInputPassword"
                        placeholder="Password"
                      />
                      <small v-if="errors.password" class="text-danger">
                        {{ errors.password.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <input
                      v-model="form.password_confirmation"
                        type="password"
                        class="form-control"
                        id="exampleInputPasswordRepeat"
                        placeholder="Repeat Password"
                      />
                      <small v-if="errors.password_confirmation" class="text-danger">
                        {{ errors.password_confirmation.join() }}
                      </small>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                        Register
                      </button>
                    </div>
                  </form>
                  <hr />
                  <div class="text-center">
                    <router-link :to="{name : 'Login' }" class="font-weight-bold small" href="login.html"
                      >Already have an account? </router-link>
                  </div>
                  <div class="text-center"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import constant from '../../constants'
import axios from 'axios'
import User from '../../helper/user'

export default {
  created(){
    if(User.loggedIn()){
      this.$router.push({name: 'Home' })
    }
  },
  data(){
    return {
      form : {
        name : null,
        email: null,
        password : null,
        password_confirmation: null,
      },
      errors : {},
    
    }
  },

  methods: {
    register(){
      axios.post(`${constant.API_URL}auth/register`, this.form)
      .then((res) =>{ Toast.fire({
        icon: 'success',
        title: `${res.data.message}`
      })
        this.$router.push({name: 'Login'})
      })
      .catch(e => {
        if(e.response.data){
          this.errors = e.response.data.errors
        } else {
          console.log(e);
        }
        })
    }
  }

};
</script>

<style>
</style>