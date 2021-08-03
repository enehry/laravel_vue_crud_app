<template>
  <div class="login">
    <!-- Login Content -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Forget Password</h1>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail"
                        aria-describedby="emailHelp"
                        placeholder="Enter Existing Email Address"
                      />
                    </div>
                    <div class="form-group">
                      <a href="index.html" class="btn btn-primary btn-block"
                        >Forget Password</a
                      >
                    </div>
                  </form>
                  <hr />
                  <div class="text-center">
                    <router-link
                      :to="{ name: 'Login' }"
                      class="font-weight-bold small"
                      >Back to login</router-link
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
  <!-- Login Content -->
</template>
<script>
export default {};
</script>

<style>
</style>