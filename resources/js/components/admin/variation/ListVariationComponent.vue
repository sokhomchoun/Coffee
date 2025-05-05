
<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t('menu.variation') }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <!-- <div class="dropdown-group">
                        <ExportComponent />
                        <div class="dropdown-list db-card-filter-dropdown-list">
                            <PrintComponent :props="printObj" />
                            <ExcelComponent :method="xls" />
                        </div>
                    </div> -->
                    <div v-if="permissionChecker('items_create')" class="dropdown-group">
                        <ImportComponent />
                         <div class="dropdown-list db-card-filter-dropdown-list">
                            <SampleFileComponent @click="downloadSample" />
                            <UploadFileComponent :dataModal="'itemUpload'"  @click="uploadModal('#itemUpload')" />
                        </div>
                    </div>
                    <AddVariationComponent :props="props" v-if="permissionChecker('variation_create')" />
                </div>
            </div>
            <div class="db-table-responsive">
                <table class="db-table stripe" id="print" :dir="direction">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr flex justify-between">
                            <th class="db-table-head-th">
                                {{ $t('label.name') }}
                            </th>
                            <th class="db-table-head-th">
                                {{ $t('label.variation_type') }}
                            </th>
                            <th class="db-table-head-th hidden-print">
                                {{ $t('label.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="db-table-body" v-if="items.length > 0">
                        <tr class="db-table-body-tr flex justify-between" v-for="item in items" :key="item.id">
                            <td class="db-table-body-td">{{ item.name }}</td>
                            <td class="db-table-body-td">
                                <span v-for="(type, index) in item.type" :key="index">
                                    {{ type.name }}{{ index < item.type.length - 1 ? ",&nbsp;" : "" }}
                                </span>
                            </td>
                            <td class="db-table-body-td hidden-print"
                                v-if="permissionChecker('variation_edit') || permissionChecker('variation_delete')">
                                <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                    <!-- <SmIconViewComponent /> -->
                                    <SmIconSidebarModalEditComponent @click="edit(item)"
                                        v-if="permissionChecker('variation_edit')"/>
                                    <SmIconDeleteComponent @click="destroy(item)"
                                        v-if="permissionChecker('variation_delete')"/>
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
import AddVariationComponent from './AddVariationComponent';
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
import UploadFileComponent from "../components/buttons/import/UploadFileComponent.vue";
import ImportComponent from "../components/buttons/import/ImportComponent.vue";
import alertService from "../../../services/alertService";

export default {
    name: "ListVariationComponent",
    components: {
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        AddVariationComponent,
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
                    id: "",
                    name: "",
                    type: [],
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: 'id',
                    order_type: 'desc',
                    id: "",
                    name: "",
                    type: "",
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
            return this.$store.getters['variation/lists'];
        },
        pagination: function () {
            return this.$store.getters['variation/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['variation/page'];
        },
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch('variation/lists', this.props.search).then(res => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (item) {
            appService.sideDrawerShow();
            this.loading.isActive = true;
            this.$store.dispatch('variation/edit', item);
            this.loading.isActive = false;
            this.props.errors = {};
            this.props.form = {
                id: item.id,
                name: item.name,
                type: item.type,
            }
        },
        destroy: function (item) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('variation/destroy', { id: item.id, name: item.name, search: this.props.search }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('menu.variation'));
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
</style>
