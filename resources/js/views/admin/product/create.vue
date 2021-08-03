<template>
  <div class="CreateProduct">
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
          <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
        </div>
        <div class="card-body">
          <form @submit.prevent="saveProduct" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-4">
                <label for="">Category</label>
                <select v-model="form.category_id" class="form-control mb-3">
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.category_name }}
                  </option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="">Supplier</label>
                <select v-model="form.supplier_id" class="form-control mb-3">
                  <option
                    v-for="supplier in suppliers"
                    :key="supplier.id"
                    :value="supplier.id"
                  >
                    {{ supplier.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Buying Date</label>
                  <input
                    v-model="form.buying_date"
                    type="date"
                    class="form-control"
                    id="inputDate"
                  />
                  <small class="text-danger" v-if="errors.product_code">
                    {{ errors.buying_date.join() }}
                  </small>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Product Name</label>
              <input
                v-model="form.product_name"
                type="text"
                class="form-control"
                id="inputProductName"
                placeholder="Enter Product Name"
              />
              <small class="text-danger" v-if="errors.product_name">
                {{ errors.product_name.join() }}
              </small>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Product Code</label>
                  <input
                    v-model="form.product_code"
                    type="text"
                    class="form-control"
                    id="inputSalary"
                    placeholder="Enter Product Code"
                  />
                  <small class="text-danger" v-if="errors.product_code">
                    {{ errors.product_code.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Root</label>
                  <input
                    v-model="form.root"
                    type="text"
                    class="form-control"
                    id="inputroot"
                    placeholder="Enter Root"
                  />
                  <small class="text-danger" v-if="errors.root">
                    {{ errors.root.join() }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Buying Price</label>
                  <input
                    v-model="form.buying_price"
                    type="text"
                    class="form-control"
                    id="inputPrice"
                    placeholder="Enter Buying Price"
                  />
                  <small class="text-danger" v-if="errors.buying_price">
                    {{ errors.buying_price.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Selling Price</label>
                  <input
                    v-model="form.selling_price"
                    type="text"
                    class="form-control"
                    id="inputPrice"
                    placeholder="Enter Selling Price"
                  />
                  <small class="text-danger" v-if="errors.selling_price">
                    {{ errors.selling_price.join() }}
                  </small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Product Quantity</label>
                  <input
                    v-model="form.product_quantity"
                    type="number"
                    class="form-control"
                    id="inputPQunatity"
                    placeholder="Enter Product Quantity"
                  />
                  <small class="text-danger" v-if="errors.product_quantity">
                    {{ errors.product_quantity.join() }}
                  </small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between">
                  <img
                    :src="form.image"
                    style="height: 80px; width: 80px"
                    alt=""
                  />
                  <div class="form-group">
                    <label for="">Image</label>
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
                        {{ errors.image.join() }}
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
import AppStorage from "../../../helper/app_storage";

export default {
  created() {
    this.getCategoryAndSupplier();
  },
  data() {
    return {
      form: {
        category_id: null,
        product_name: null,
        product_code: null,
        root: null,
        buying_price: null,
        selling_price: null,
        supplier_id: null,
        buying_date: null,
        image: null,
        product_quantity: null,
      },
      categories: {},
      suppliers: {},
      errors: {},
    };
  },
  methods: {
    saveProduct() {
      let token = AppStorage.getToken();

      axios
        .post(`${CONSTS.API_URL}admin/product/create`, this.form, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          let data = res.data;
          console.log(data.success);
          if (data.success) {
            Toast.fire({
              icon: "success",
              title: "Product Successfully Added",
            });
            this.$router.push({ name: "AllProduct" });
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
    getCategoryAndSupplier() {
      let token = AppStorage.getToken();
      axios
        .get(`${CONSTS.API_URL}admin/product/categorySupplier`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.suppliers = res.data.supplier;

            this.categories = res.data.category;
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
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 2048770) {
        Notification.error("Image should not exceed more than 2MB");
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.image = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
  },
};
</script>

<style>
</style>