import StockComponent from "../../components/admin/stocks/StockComponent.vue";
import ListStockComponent from "../../components/admin/stocks/ListStockComponent.vue";

export default [
    {
        path: "/admin/stock",
        component: StockComponent,
        name: "admin.stock",
        redirect: { name: "admin.stock.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "stock",
            breadcrumb: "stock",
        },
        children: [
            {
                path: '',
                component: ListStockComponent,
                name: "admin.stock.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "stock",
                    breadcrumb: '',
                },
            }
        ],
    }
]
