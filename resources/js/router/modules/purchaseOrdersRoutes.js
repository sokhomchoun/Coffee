import PurchaseOrdersComponent from "../../components/admin/purchaseOrders/PurchaseOrdersComponent.vue";
import PurchaseOrdersListComponent from "../../components/admin/purchaseOrders/PurchaseOrdersListComponent.vue";

export default [
    {
        path: "/admin/purchase_orders",
        component: PurchaseOrdersComponent,
        name: "admin.purchase_orders",
        redirect: { name: "admin.purchase_orders.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "purchase_orders",
            breadcrumb: "purchase_orders",
        },
        children: [
            {
                path: "",
                component: PurchaseOrdersListComponent,
                name: "admin.purchase_orders.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "purchase_orders",
                    breadcrumb: "",
                },
            },
        ],
    },
];
