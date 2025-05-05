import VariationComponent from "../../components/admin/variation/VariationComponent.vue";
import ListVariationComponent from "../../components/admin/variation/ListVariationComponent.vue";

export default [
    {
        path: "/admin/variation",
        component: VariationComponent,
        name: "admin.variation",
        redirect: { name: "admin.variation.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "variation",
            breadcrumb: "variation",
        },
        children: [
            {
                path: '',
                component: ListVariationComponent,
                name: "admin.variation.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "variation",
                    breadcrumb: '',
                },
            }
        ],
    },
];
