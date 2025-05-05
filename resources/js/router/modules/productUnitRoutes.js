import UnitComponent from "../../components/admin/productUnits/UnitComponent.vue";
import UnitListComponent from "../../components/admin/productUnits/UnitListComponent.vue";

export default [
    {
        path: "/admin/unit",
        component: UnitComponent,
        name: "admin.unit",
        redirect: { name: "admin.unit" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "unit",
            breadcrumb: "unit",
        },
        children: [
            {
                path: '',
                component: UnitListComponent,
                name: "admin.unit.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "unit",
                    breadcrumb: '',
                },
            }
        ],
    }
]
