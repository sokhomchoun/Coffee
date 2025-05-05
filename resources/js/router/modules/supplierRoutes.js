import SupplierComponent from "../../components/admin/supplier/SupplierComponent.vue";
import SupplierListComponent from "../../components/admin/supplier/SupplierListComponent.vue";
export default [
    {
        path: "/admin/supplier",
        component: SupplierComponent,
        name: "admin.supplier",
        redirect: { name: "admin.supplier.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "supplier",
            breadcrumb: "supplier",
        },
        children: [
            {
                path: "",
                component: SupplierListComponent,
                name: "admin.supplier.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "supplier",
                    breadcrumb: "",
                },
            },
        ],
    },
];
