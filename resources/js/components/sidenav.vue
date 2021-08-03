<template>
  <nav id="sidebar">
    <!-- Sidebar -->
    <ul
      class="navbar-nav sidebar sidebar-light accordion"
      id="accordionSidebar"
    >
      <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="index.html"
      >
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>
      <hr class="sidebar-divider my-0" />
      <li class="nav-item active">
        <router-link class="nav-link" :to="{ name: 'Home' }">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></router-link
        >
      </li>
      <hr class="sidebar-divider" />
      <div class="sidebar-heading">Features</div>
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseEmployee"
          aria-expanded="true"
          aria-controls="collapseBootstrap"
        >
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Employee</span>
        </a>
        <div
          id="collapseEmployee"
          class="collapse"
          aria-labelledby="headingBootstrap"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Employee</h6>
            <router-link :to="{ name: 'CreateEmployee' }" class="collapse-item"
              >Add Employee</router-link
            >
            <router-link :to="{ name: 'AllEmployee' }" class="collapse-item"
              >All Employee</router-link
            >
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseTable"
          aria-expanded="true"
          aria-controls="collapseTable"
        >
          <i class="fas fa-fw fa-table"></i>
          <span>Suppliers</span>
        </a>
        <div
          id="collapseTable"
          class="collapse"
          aria-labelledby="headingTable"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Suppliers</h6>
            <router-link :to="{ name: 'CreateSupplier' }" class="collapse-item"
              >Add Supplier</router-link
            >
            <router-link :to="{ name: 'AllSupplier' }" class="collapse-item"
              >All Supplier</router-link
            >
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapseProduct"
          aria-expanded="true"
          aria-controls="collapseTable"
        >
          <i class="fas fa-fw fa-table"></i>
          <span>Products</span>
        </a>
        <div
          id="collapseProduct"
          class="collapse"
          aria-labelledby="headingTable"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Products</h6>
            <router-link :to="{ name: 'CreateProduct' }" class="collapse-item"
              >Add Product</router-link
            >
            <router-link :to="{ name: 'AllProduct' }" class="collapse-item"
              >All Products</router-link
            >
          </div>
        </div>
      </li>
      <li class="nav-item">
        <router-link :to="{ name : 'AllCategory'}"
          class="nav-link"
        >
          <i class="fas fa-fw fa-table"></i>
          <span>Category</span>
        </router-link>
      </li>
      
    </ul>
    <!-- Sidebar -->
  </nav>
</template>

<script>
export default {};
</script>

<style>
</style>