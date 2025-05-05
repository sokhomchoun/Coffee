import ProductComponent from "../../components/admin/products/ProductComponent.vue";
import ProductListComponent from "../../components/admin/products/ProductListComponent.vue";


export default [
    {
        path: "/admin/product",
        component: ProductComponent,
        name: "admin.product",
        redirect: { name: "admin.product" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "product",
            breadcrumb: "product",
        },
        children: [
            {
                path: '',
                component: ProductListComponent,
                name: "admin.product.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "product",
                    breadcrumb: '',
                },
            }



        ],
    }
]
