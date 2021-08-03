<template>
  <div id="notfound">
    <!-- <div class="text-center">
      <h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
      <p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
    </div> -->
    <div class="outer">
      <div class="middle">
        <div class="inner">
          <h1 class="text-gray-800">404</h1>
          <p class="">PAGE NOT FOUND</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
.outer {
  display: table;
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}

.middle {
  display: table-cell;
  vertical-align: middle;
}

.inner {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  width: 400px;
  /* Whatever width you want */
}
</style>