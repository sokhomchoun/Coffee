<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card db-tab-div active">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t("menu.purchase_orders") }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <PurchaseOrdersCreateComponent :props="props" v-if="permissionChecker('purchase_orders_create')" />
                </div>
            </div>

            <div class="db-table-responsive">
                <table class="db-table stripe" id="print" :dir="direction">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr">
                            <th class="db-table-head-th">{{ $t("label.purchase_orders") }}</th>
                            <th class="db-table-head-th">{{ $t("label.supplier") }}</th>
                            <th class="db-table-head-th">{{ $t("label.date") }}</th>
                            <th class="db-table-head-th hidden-print"
                                v-if="permissionChecker('purchase_orders_edit') || permissionChecker('purchase_orders_delete')">
                                {{ $t("label.action") }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="db-table-body" v-if="Array.isArray(purchaseOrders) && purchaseOrders.length">
                        <tr class="db-table-body-tr" v-for="item in purchaseOrders" :key="item">
                            <td class="db-table-body-td">
                                <div>{{ item.supplier.name }}</div>
                            </td>
                            <td class="db-table-body-td">
                                <div> {{ item.branch.name }}</div>
                            </td>
                            <td class="db-table-body-td">
                                <div>{{ item.date }}</div>
                            </td>
                            <td class="db-table-body-td hidden-print"
                                v-if="permissionChecker('purchase_orders_edit') || permissionChecker('purchase_orders_delete')">
                                <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                    <SmIconSidebarModalEditComponent @click="edit(item)"
                                        v-if="permissionChecker('purchase_orders_edit')" />
                                    <SmIconDeleteComponent @click="destroy(item.id)"
                                        v-if="permissionChecker('purchase_orders_delete')" />
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6">
                <PaginationSMBox :pagination="pagination" :method="list" />
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <PaginationTextComponent :props="{ page: paginationPage }" />
                    <PaginationBox :pagination="pagination" :method="list" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "../components/LoadingComponent";
import PurchaseOrdersCreateComponent from "./PurchaseOrdersCreateComponent.vue";
import alertService from "../../../services/alertService";
import PaginationTextComponent from "../components/pagination/PaginationTextComponent";
import PaginationBox from "../components/pagination/PaginationBox";
import PaginationSMBox from "../components/pagination/PaginationSMBox";
import appService from "../../../services/appService";
import taxTypeEnum from "../../../enums/modules/taxTypeEnum";
import TableLimitComponent from "../components/TableLimitComponent";
import SmIconDeleteComponent from "../components/buttons/SmIconDeleteComponent";
import SmIconSidebarModalEditComponent from "../components/buttons/SmIconSidebarModalEditComponent";
import ExportComponent from "../components/buttons/export/ExportComponent";
import PrintComponent from "../components/buttons/export/PrintComponent";
import ExcelComponent from "../components/buttons/export/ExcelComponent";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import displayModeEnum from "../../../enums/modules/displayModeEnum";

export default {
    name: "PurchaseOrdersListComponent",
    components: {
        SmIconSidebarModalEditComponent,
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        PurchaseOrdersCreateComponent,
        LoadingComponent,
        SmIconDeleteComponent,
        ExportComponent,
        PrintComponent,
        ExcelComponent,
        Datepicker,
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                taxTypeEnum: taxTypeEnum,
                taxTypeEnumArray: {
                    [taxTypeEnum.FIXED]: this.$t("label.fixed"),
                    [taxTypeEnum.PERCENTAGE]: this.$t("label.percentage"),
                },
            },

            printLoading: true,
            printObj: {
                id: "print",
                popTitle: this.$t('menu.purchase_orders')
            },
            props: {
                form: {
                    date: null,
                    supplier_id: null,
                    branch_id: null,
                    items: [],
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: "id",
                    order_type: "desc",
                    // date: "",
                    // supplier_id: "",
                    // branch_id: "",
                    // items: ""
                },
            },
        };
    },
    mounted() {
        this.list();
        this.loading.isActive = true;
        this.props.search.page = 1;
    },
    computed: {
        purchaseOrders: function () {
            return this.$store.getters["purchaseOrders/lists"];
        },
        pagination: function () {
            return this.$store.getters["purchaseOrders/pagination"];
        },
        paginationPage: function () {
            return this.$store.getters["purchaseOrders/page"];
        },
        direction: function () {
            return this.$store.getters['frontendLanguage/show'].display_mode === displayModeEnum.RTL ? 'rtl' : 'ltr';
        },
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch("purchaseOrders/lists", this.props.search).then((res) => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (item) {
            appService.sideDrawerShow();
            this.loading.isActive = true;
            this.$store.dispatch("purchaseOrders/edit", item)
            this.loading.isActive = false;
            this.props.errors = {};
            // this.props.form = item;
            this.props.form = {
                id: item.id,
                supplier_id: item.supplier_id,
                branch_id: item.branch_id,
                date: item.date,
                items: item.items || []
            };

        },

        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch("purchaseOrders/destroy", {
                        id: id,
                        search: this.props.search,
                    }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(
                            null,
                            this.$t("menu.purchase_orders")
                        );
                    }).catch((err) => {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.message);
                    });
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
    },
};

</script>
<style scoped>
@media print {
    .hidden-print {
        display: none !important;
    }
}
</style>
