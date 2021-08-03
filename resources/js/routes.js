import Login from './views/auth/login.vue'
import Register from './views/auth/register.vue'
import Forget from './views/auth/forget.vue'
import Home from './views/home.vue'
import Logout from './views/auth/logout.vue'
import Admin from './views/admin/admin.vue'
import CreateEmployee from './views/admin/employee/create_employee.vue'
import AllEmployee from './views/admin/employee/index.vue'
import EditEmployee from './views/admin/employee/edit_employee.vue'
import PageNotFound from './views/page_not_found.vue'
import AllSupplier from './views/admin/supplier/index.vue'
import CreateSupplier from './views/admin/supplier/create.vue'
import EditSupplier from './views/admin/supplier/edit.vue'
import AllCategory from './views/admin/category/index.vue'
import AllProduct from './views/admin/product/index.vue'
import CreateProduct from './views/admin/product/create.vue'
import EditProduct from './views/admin/product/edit.vue'

const routes = [
    {
        path : '/admin' ,
        name : 'Admin',
        component : Admin,
        children: [
            {
                path: '/home',
                name: 'Home',
                component: Home
            },
            {
                path: '/create-employee',
                name: 'CreateEmployee',
                component: CreateEmployee,
            },
            {
                path: '/edit-employee/:id',
                name: 'EditEmployee',
                component: EditEmployee,
                props : true
            },
            {
                path: '/all-employee',
                name: 'AllEmployee',
                component: AllEmployee
            },
            {
                path: '/all-supplier',
                name: 'AllSupplier',
                component: AllSupplier
            },
            {
                path: '/create-supplier',
                name: 'CreateSupplier',
                component: CreateSupplier
            },
            {
                path: '/edit-supplier/:id',
                name: 'EditSupplier',
                component: EditSupplier,
                props : true
            },
            {
                path: '/all-category',
                name: 'AllCategory',
                component: AllCategory,
            },
            {
                path: '/all-products',
                name: 'AllProduct',
                component: AllProduct,
            },
            {
                path: '/create-products',
                name: 'CreateProduct',
                component: CreateProduct,
            },
            {
                path: '/edit-products/:id',
                name: 'EditProduct',
                component: EditProduct,
                props : true
            },
        ]
    },
   {
        path : '/' ,
        name : 'Login',
        component : Login
    },
    {
        path : '/register' ,
        name : 'Register',
        component : Register
    },
    {
        path : '/logout' ,
        name : 'Logout',
        component : Logout
    },
    {
        path : '/forget' ,
        name : 'Forget',
        component : Forget
    },
    {
        path: "*", component: PageNotFound
    }
]

export default routes