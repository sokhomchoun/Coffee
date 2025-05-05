<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card db-tab-div active">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t("menu.supplier") }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <SupplierCreateComponent :props="props" v-if="permissionChecker('supplier_create')" />
                </div>
            </div>
          
            <div class="db-table-responsive">
                <table class="db-table stripe" id="print" :dir="direction">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr">
                            <th class="db-table-head-th">{{ $t("label.supplier") }}</th>
                            <th class="db-table-head-th">{{ $t("label.phone_number") }}</th>
                            <th class="db-table-head-th">{{ $t("label.created_on") }}</th>
                            <th class="db-table-head-th hidden-print"
                                v-if="permissionChecker('supplier_edit') || permissionChecker('supplier_delete')">
                                {{ $t("label.action") }}</th>
                        </tr>
                    </thead>
                   
                    <tbody class="db-table-body" v-if="suppliers.length > 0">
                        <tr class="db-table-body-tr" v-for="supplier in suppliers" :key="supplier">
                            <td class="db-table-body-td">
                                <div v-if="supplier.name.length < 40"> {{ supplier.name }}</div>
                                <div v-else>{{ supplier.name.substring(0, 40) + ".." }}</div>
                            </td>
                            <td class="db-table-body-td">
                                <div> {{ supplier.phone_number }}</div>
                            </td>
                            <td class="db-table-body-td">
                                <div>{{ supplier.datetime }}</div>
                            </td>
                            <td class="db-table-body-td hidden-print"
                                v-if="permissionChecker('supplier_edit') || permissionChecker('supplier_delete')">
                                <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                    <SmIconSidebarModalEditComponent @click="edit(supplier)"
                                        v-if="permissionChecker('supplier_edit')" />
                                    <SmIconDeleteComponent @click="destroy(supplier.id)"
                                        v-if="permissionChecker('supplier_delete')" />
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
import SupplierCreateComponent from "./SupplierCreateComponent.vue";
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
    name: "SupplierListComponent",
    components: {
        SmIconSidebarModalEditComponent,
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        SupplierCreateComponent,
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
                popTitle: this.$t('menu.supplier')
            },
            props: {
                form: {
                    name: "",
                    email: "",
                    phone_number: "",
                    country: "",
                    city: "",
                    address: "",
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: "id",
                    order_type: "desc",
                    name: "",
                    email: "",
                    phone_number: "",
                    country: "",
                    city: "",
                    address: "",
                },
            },
        };
    },
    mounted() {
        this.list();
    },
    computed: {
        suppliers: function () {
            return this.$store.getters["supplier/lists"];
        },
        pagination: function () {
            return this.$store.getters["supplier/pagination"];
        },
        paginationPage: function () {
            return this.$store.getters["supplier/page"];
        },
        direction: function () {
            return this.$store.getters['frontendLanguage/show'].display_mode === displayModeEnum.RTL ? 'rtl' : 'ltr';
        },
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        floatNumber(e) {
            return appService.floatNumber(e);
        },
        clear: function () {
            this.props.search.paginate = 1;
            this.props.search.page = 1;
            this.props.search.name = "";
            this.props.search.email = "";
            this.props.search.phone_number = "";
            this.props.search.country = "";
            this.props.search.city = "";
            this.props.search.address = "";
            this.props.search.limit_per_user = "";
            this.list();
        },
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch("supplier/lists", this.props.search).then((res) => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (supplier) {
            appService.sideDrawerShow();
            this.loading.isActive = true;
            this.$store.dispatch("supplier/edit", supplier)
            this.loading.isActive = false;
            this.props.errors = {};
            this.props.form = supplier;
        },

        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch("supplier/destroy", {
                        id: id,
                        search: this.props.search,
                    }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(
                            null,
                            this.$t("menu.supplier")
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
