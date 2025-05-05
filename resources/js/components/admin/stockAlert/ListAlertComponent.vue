
<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t('menu.stockalert') }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                </div>
            </div>
            <div class="db-table-responsive">
                <table class="db-table stripe" id="print">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr flex justify-between">
                            <th class="db-table-head-th">{{ $t('label.name') }}</th>
                            <th class="db-table-head-th">{{ $t('label.qty') }}</th>
                            <th class="db-table-head-th">{{ $t('label.branch') }}</th>
                            <th class="db-table-head-th">{{ $t('label.unit') }}</th>
                        </tr>
                    </thead>
                    <tbody class="db-table-body" v-if="items.length > 0">
                        <tr class="db-table-body-tr flex justify-between" v-for="item in items" :key="item">
                            <td class="db-table-body-td">{{ item.name }}</td>
                            <td class="db-table-body-td">{{ item.qty }}</td>
                            <td class="db-table-body-td">{{ branchName(item.branch_id) }}</td>
                            <td class="db-table-body-td">{{ unitName(item.unit_id) }}</td>
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
    name: "ListAlertComponent",
    components: {
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
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
        this.listUnit();
        this.listBranch();
        this.loading.isActive = true;
        this.props.search.page = 1;
    },
    computed: {
        items: function () {
            return this.$store.getters['stockalert/lists'];
        },
        pagination: function () {
            return this.$store.getters['stockalert/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['stockalert/page'];
        },
        listUnits() {
            return this.$store.getters['product/listUnits'];
        },
        listBranchs() {
            return this.$store.getters['product/listBranchs'];
        },
    },
    methods: {
        list: function (page = 1) {
            try {
                this.loading.isActive = true;
                this.props.search.page = page;
                this.$store.dispatch('stockalert/lists', this.props.search).then(res => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        listUnit: function() {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listUnits').then(res => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        listBranch: function() {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listBranchs').then(res => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        branchName: function (branchId) {
            const branch = this.listBranchs.find(branch => branch.id === branchId);
            return branch ? branch.name : 'Unknown Branch';
        },
        unitName: function (unitId) {
            const unit = this.listUnits.find(unit => unit.id === unitId);
            return unit ? unit.name : 'Unknown Unit';
        },
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
