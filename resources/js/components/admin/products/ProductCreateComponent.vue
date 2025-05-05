<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer max-w-[45rem]">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.product_menu") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">{{ $t("label.name") }}</label>
                        <input v-model="fd.name" type="text" id="name" class="db-field-control">
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="id" class="db-field-title required">{{ $t("label.brand") }}</label>
                            <vue-select
                                v-if="listBrands.length"
                                class="db-field-control f-b-custom-select"
                                id="id"
                                v-model="fd.brand_id"
                                :value-by="'id'"
                                :label-by="'name'"
                                :options="listBrands"
                                :closeOnSelect="true"
                                :searchable="true"
                                :clearOnClose="true"
                                placeholder="--"
                                search-placeholder="--"
                            />
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="id" class="db-field-title required">{{ $t("label.category") }}</label>
                            <vue-select
                                v-if="listCategories.length"
                                class="db-field-control f-b-custom-select"
                                id="id"
                                v-model="fd.category_id"
                                :value-by="'id'"
                                :label-by="'name'"
                                :options="listCategories"
                                :closeOnSelect="true"
                                :searchable="true"
                                :clearOnClose="true"
                                placeholder="--"
                                search-placeholder="--"
                            />
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="id" class="db-field-title required">{{ $t("label.unit") }}</label>
                            <vue-select
                                v-if="listUnits.length"
                                class="db-field-control f-b-custom-select"
                                id="id"
                                v-model="fd.unit_id"
                                :value-by="'id'"
                                :label-by="'name'"
                                :options="listUnits"
                                :closeOnSelect="true"
                                :searchable="true"
                                :clearOnClose="true"
                                placeholder="--"
                                search-placeholder="--"
                            />
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="id" class="db-field-title required">{{ $t("label.branch") }}</label>
                            <vue-select
                                v-if="listBranchs.length"
                                class="db-field-control f-b-custom-select"
                                id="id"
                                v-model="fd.branch_id"
                                :value-by="'id'"
                                :label-by="'name'"
                                :options="listBranchs"
                                :closeOnSelect="true"
                                :searchable="true"
                                :clearOnClose="true"
                                placeholder="--"
                                search-placeholder="--"
                            />
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="name" class="db-field-title required">{{ $t("label.product_cost") }}</label>
                        <input v-model="fd.product_cost" type="number" id="name" class="db-field-control" placeholder="0">
                    </div>
                    <div class="form-col-12 sm:form-col-6">
                        <label for="name" class="db-field-title required">{{ $t("label.stock_alert") }}</label>
                        <input v-model="fd.stock_alert" type="number" id="name" class="db-field-control" placeholder="0">
                    </div>
                    <div class="col-12">
                        <div class="flex flex-wrap gap-3 mt-4">
                            <button type="submit" class="db-btn py-2 text-white bg-primary">
                                <i class="lab lab-save"></i>
                                <span>{{ $t("label.save") }}</span>
                            </button>
                            <button type="button" class="modal-btn-outline modal-close" @click="reset">
                                <i class="lab lab-close"></i>
                                <span>{{ $t("button.close") }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>

import appService from '../../../services/appService';
import LoadingComponent from '../components/LoadingComponent.vue';
import SmSidebarModalCreateComponent from "../components/buttons/SmSidebarModalCreateComponent.vue";
import alertService from "../../../services/alertService";

export default {
    components: { LoadingComponent, SmSidebarModalCreateComponent },
    props: ['props'],
    data() {
        return {
            loading: {
                isActive: false
            },
            fd: {
                name: "",
                category_id: null,
                brand_id: null,
                branch_id: null,
                unit_id: null,
                product_cost: null,
                stock_alert: null
            },
            errors: {},
        }
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_product") }
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
        }
    },
    watch: {
        'props.form': {
            handler(state) {
                if (state) {
                    this.fd = {
                        id: state.id,
                        name: state.name,
                        category_id: state.category_id,
                        brand_id: state.brand_id,
                        branch_id: state.branch_id,
                        unit_id: state.unit_id,
                        product_cost: state.product_cost,
                        stock_alert: state.stock_alert
                    };
                }
            },
            deep: true
        }
    },
    mounted() {
        this.listBrand();
        this.listUnit();
        this.listBranch();
        this.listCategory();

    },
    methods: {
        reset: function() {
            appService.sideDrawerHide();
            this.$store.dispatch('product/reset').then().catch();
            this.errors = {};
            this.fd = {
                name: "",
                category_id: null,
                brand_id: null,
                branch_id: null,
                unit_id: null,
                product_cost: null,
                stock_alert: null
            };
        },
        listBrand: function() {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listBrands').then(res => {
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
        listCategory: function() {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listCategories').then(res => {
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
        save: function() {
            try {
                const tempId = this.$store.getters['product/temp'].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch('product/save', {
                    form: this.fd,
                    search: this.props.search
                }).then((res) => {
                    appService.sideDrawerHide();
                    alertService.successFlip((tempId === null ? 0 : 1), this.$t('menu.product'));
                    this.errors = {};
                    this.reset();
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = {};
                    if (err.response && err.response.data && err.response.data.errors) {
                        this.errors = err.response.data.errors;
                    } else {
                        alertService.error(err.response.data.message);
                    }
                }).finally(() => {
                    this.loading.isActive = false;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err)
            }
        }
    }
}
</script>
