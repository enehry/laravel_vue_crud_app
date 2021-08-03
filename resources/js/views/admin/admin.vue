<template>
  <div>
    <div id="app">
      <div id="wrapper">
        <Sidenav />
        <div id="content-wrapper" class="d-flex flex-column">
          <div id="content">
            <TopBar />
            <div class="container-fluid" id="container-wrapper">
              <router-view></router-view>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidenav from "../../components/sidenav.vue";
import TopBar from "../../components/topbar.vue";

export default {
  components: {
    Sidenav,
    TopBar,
  },
};
</script>