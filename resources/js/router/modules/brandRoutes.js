import BrandComponent from "../../components/admin/brands/BrandComponent.vue";
import BrandListComponent from "../../components/admin/brands/BrandListComponent.vue";

export default [
    {
        path: "/admin/brand",
        component: BrandComponent,
        name: "admin.brand",
        redirect: { name: "admin.brand" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "brand",
            breadcrumb: "brand",
        },
        children: [
            {
                path: '',
                component: BrandListComponent,
                name: "admin.brand.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "brand",
                    breadcrumb: '',
                },
            }
        ],
    }
]
