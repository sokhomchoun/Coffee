<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t('menu.product_menu') }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <ProductCreateComponent :props="props" v-if="permissionChecker('product_create')" />
                </div>
            </div>
            <div class="db-table-responsive">
                <table class="db-table stripe" id="print">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr flex justify-between">
                            <th class="db-table-head-th"> {{ $t('label.name') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.category') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.brand') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.branch') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.unit') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.product_cost') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.stock_alert') }}</th>
                            <th class="db-table-head-th"> {{ $t('label.action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="db-table-body" v-if="items.length > 0">
                        <tr class="db-table-body-tr flex justify-between" v-for="item in items" :key="item.id">
                            <td class="db-table-body-td">{{ item.name }}</td>
                            <td class="db-table-body-td">{{ categoryName(item.category_id) }}</td>
                            <td class="db-table-body-td">{{ brandName(item.brand_id) }}</td>
                            <td class="db-table-body-td">{{ branchName(item.branch_id) }}</td>
                            <td class="db-table-body-td">{{ unitName(item.unit_id) }}</td>
                            <td class="db-table-body-td">{{ item.product_cost }}</td>
                            <td class="db-table-body-td">{{ item.stock_alert }}</td>
                            <td class="db-table-body-td hidden-print" v-if="permissionChecker('Product_edit') || permissionChecker('product_delete')">
                            <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                <div @click="edit(item)" v-if="permissionChecker('Product_edit')">
                                <SmIconSidebarModalEditComponent />
                                </div>
                                <SmIconDeleteComponent @click="destroy(item.id)" v-if="permissionChecker('product_delete')"/>
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
import ProductCreateComponent from "./ProductCreateComponent.vue";
import SmIconViewComponent from '../components/buttons/SmIconViewComponent';
import SmIconSidebarModalEditComponent from '../components/buttons/SmIconSidebarModalEditComponent';
import SmIconDeleteComponent from '../components/buttons/SmIconDeleteComponent';
import PaginationTextComponent from "../components/pagination/PaginationTextComponent";
import PaginationBox from "../components/pagination/PaginationBox";
import PaginationSMBox from "../components/pagination/PaginationSMBox";
import TableLimitComponent from "../components/TableLimitComponent";
import appService from "../../../services/appService";
import FilterComponent from "../components/buttons/collapse/FilterComponent";
import ExportComponent from "../components/buttons/export/ExportComponent";
import PrintComponent from "../components/buttons/export/PrintComponent";
import ExcelComponent from "../components/buttons/export/ExcelComponent";
import SampleFileComponent from "../components/buttons/import/SampleFileComponent.vue";
import alertService from "../../../services/alertService";

export default {
    name: "ListVariationComponent",
    components: {
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        ProductCreateComponent,
        LoadingComponent,
        SmIconViewComponent,
        SmIconSidebarModalEditComponent,
        SmIconDeleteComponent,

        FilterComponent,
        ExportComponent,
        PrintComponent,
        ExcelComponent,
        SampleFileComponent

    },
    data() {
        return {
            loading: {
                isActive: false
            },
            props: {
                form: {
                    id: null,
                    name: "",
                    category_id: null,
                    brand_id: null,
                    branch_id: null,
                    unit_id: null,
                    product_cost: null,
                    stock_alert: null
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: 'id',
                    order_type: 'desc',
                }
            }
        }
    },
    mounted() {
        this.list();
        this.loading.isActive = true;
        this.props.search.page = 1;
    },
    computed: {
        items: function () {
            return this.$store.getters['product/lists'];
        },
        listBrands() {
            return this.$store.getters['product/listBrands'];
        },
        listUnits() {
            return this.$store.getters['product/listUnits'];
        },
        listBranchs() {
            return this.$store.getters['product/listBranchs'];
        },
        listCategories() {
            return this.$store.getters['product/listCategories'];
        },
        pagination: function () {
            return this.$store.getters['product/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['product/page'];
        },
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        list: function (page = 1) {
            try {
                this.loading.isActive = true;
                this.props.search.page = page;
                this.$store.dispatch('product/lists', this.props.search).then(res => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err)
            }
        },
        edit: function (item) {
            try {
                appService.sideDrawerShow();
                this.loading.isActive = true;
                this.$store.dispatch('product/edit', item);
                this.loading.isActive = false;
                this.props.errors = {};
                this.props.form = item;
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err)
            }
        },
        categoryName: function (cateId) {
            const cate = this.listCategories.find(cate => cate.id === cateId);
            return cate ? cate.name : 'Unknown Category';
        },
        brandName: function (brandId) {
            const brand = this.listBrands.find(brand => brand.id === brandId);
            return brand ? brand.name : 'Unknown Brand';
        },
        branchName: function (branchId) {
            const branch = this.listBranchs.find(branch => branch.id === branchId);
            return branch ? branch.name : 'Unknown Branch';
        },
        unitName: function (unitId) {
            const unit = this.listUnits.find(unit => unit.id === unitId);
            return unit ? unit.name : 'Unknown Unit';
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('product/destroy', { id: id, search: this.props.search }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('menu.product'));
                    }).catch((err) => {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.message);
                    })
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }).catch((err) => {
                this.loading.isActive = false;
            });
        }

    }
}
</script>

<style scoped>
    @media print {
        .hidden-print {
            display: none !important;
        }
    }
    .db-table-head-th {
        width: 12.5%;
    }
    .db-table-body-td {
        width: 12.5%;
    }
</style>
