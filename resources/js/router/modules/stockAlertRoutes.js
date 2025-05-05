import AlertComponent from "../../components/admin/stockAlert/AlertComponent.vue"
import ListAlertComponent from "../../components/admin/stockAlert/ListAlertComponent.vue";

export default [
    {
        path: "/admin/stockalert",
        component: AlertComponent,
        name: "admin.stockalert",
        redirect: { name: "admin.stockalert.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "stockalert",
            breadcrumb: "stockalert",
        },
        children: [
            {
                path: '',
                component: ListAlertComponent,
                name: "admin.stockalert.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "stockalert",
                    breadcrumb: '',
                },
            }
        ],
    }
]
