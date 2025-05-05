<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="db-card">
            <div class="db-card-header border-none">
                <h3 class="db-card-title">{{ $t('menu.brand') }}</h3>
                <div class="db-card-filter">
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <TableLimitComponent :method="list" :search="props.search" :page="paginationPage" />
                    <BrandCreateComponent :props="props" v-if="permissionChecker('brand_create')" />
                </div>
            </div>
            <div class="db-table-responsive">
                <table class="db-table stripe" id="print">
                    <thead class="db-table-head">
                        <tr class="db-table-head-tr flex justify-between">
                            <th class="db-table-head-th">
                                {{ $t('label.name') }}
                            </th>
                            <th class="db-table-head-th">
                                {{ $t('label.status') }}
                            </th>
                            <th class="db-table-head-th hidden-print">
                                {{ $t('label.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="db-table-body" v-if="items.length > 0">
                        <tr class="db-table-body-tr flex justify-between" v-for="item in items" :key="item">
                            <td class="db-table-body-td">{{ item.name }}</td>
                            <td class="db-table-body-td">
                                <span :class="{
                                    'bg-green-100 text-green-800 db-table-badge': item.status === 'Active',
                                    'bg-red-100 text-red-800 db-table-badge': item.status === 'Inactive'
                                }">{{ item.status }}</span>
                            </td>
                            <td class="db-table-body-td hidden-print"
                                v-if="permissionChecker('brand_edit') || permissionChecker('brand_delete')">
                                <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                    <SmIconSidebarModalEditComponent @click="edit(item)"
                                        v-if="permissionChecker('brand_edit')"/>
                                    <SmIconDeleteComponent @click="destroy(item.id)"
                                        v-if="permissionChecker('brand_delete')"/>
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
import BrandCreateComponent from "./BrandCreateComponent.vue";
import SmIconViewComponent from '../components/buttons/SmIconViewComponent';
import SmIconSidebarModalEditComponent from '../components/buttons/SmIconSidebarModalEditComponent';
import SmIconDeleteComponent from '../components/buttons/SmIconDeleteComponent';
import PaginationTextComponent from "../components/pagination/PaginationTextComponent";
import PaginationBox from "../components/pagination/PaginationBox";
import PaginationSMBox from "../components/pagination/PaginationSMBox";
import TableLimitComponent from "../components/TableLimitComponent";
import appService from "../../../services/appService";
import alertService from "../../../services/alertService";

export default {
    name: "BrandListComponent",
    components: {
        TableLimitComponent,
        PaginationSMBox,
        PaginationBox,
        PaginationTextComponent,
        BrandCreateComponent,
        LoadingComponent,
        SmIconViewComponent,
        SmIconSidebarModalEditComponent,
        SmIconDeleteComponent,

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
                    status: "",
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: 'id',
                    order_type: 'desc',
                    id: "",
                    name: "",
                    status: "",
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
            return this.$store.getters['brand/lists'];
        },
        pagination: function () {
            return this.$store.getters['brand/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['brand/page'];
        },
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch('brand/lists', this.props.search).then(res => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (item) {
            appService.sideDrawerShow();
            this.loading.isActive = true;
            this.$store.dispatch('brand/edit', item);
            this.loading.isActive = false;
            this.props.errors = {};
            this.props.form = {
                id: item.id,
                name: item.name,
                status: item.status,
            }
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('brand/destroy', { id: id, search: this.props.search }).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('menu.brand'));
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
