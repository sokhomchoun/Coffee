<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.purchase_orders") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12 sm:form-col-6">
                        <label for="date" class="db-field-title required">{{ $t("label.date") }}</label>
                        <Datepicker hideInputIcon autoApply v-model="fd.date" :enableTimePicker="true" :is24="false"
                            :monthChangeOnScroll="false" utc="false"
                            :input-class-name="errors?.date ? 'invalid' : ''">
                            <template #am-pm-button="{ toggle, value }">
                                <button @click="toggle">{{ value }}</button>
                            </template>
                        </Datepicker>
                        <small class="db-field-alert" v-if="errors?.date">{{ errors.date[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="supplier_id" class="db-field-title required">{{ $t("label.supplier") }}</label>
                        <vue-select v-if="Array.isArray(listSuppliers) && listSuppliers.length"
                            class="db-field-control f-b-custom-select" id="id" v-model="fd.supplier_id" :value-by="'id'"
                            :label-by="'name'" :options="listSuppliers" :closeOnSelect="true" :searchable="true"
                            :clearOnClose="true" placeholder="--" search-placeholder="--" />
                    </div>

                    <div class="form-col-12 sm:form-col-12">
                        <label for="branch_id" class="db-field-title required">{{
                            $t("label.branch")
                        }}</label>
                        <vue-select v-if="Array.isArray(listBranchs) && listBranchs.length"
                            class="db-field-control f-b-custom-select" id="id" v-model="fd.branch_id" :value-by="'id'"
                            :label-by="'name'" :options="listBranchs" :closeOnSelect="true" :searchable="true"
                            :clearOnClose="true" placeholder="--" search-placeholder="--" />
                    </div>

                    <div class="form-col-12 sm:form-col-12">
                        <label for="product_id" class="db-field-title required">{{ $t("label.product_id") }}</label>
                        <vue-select class="db-field-control f-b-custom-select" v-model="selectedProduct"
                            :options="filteredProductOptions" :reduce="product => product.id" :closeOnSelect="true"
                            :searchable="true" :clearOnClose="true" placeholder="-- Select Product --"
                            search-placeholder="Search product..." label="name" :label-by="'name'"
                            @update:modelValue="onProductSelect" />

                        <!-- Selected Products List -->
                        <table class="table w-full border-collapse" v-if="fd.items.length">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-4 py-2 w-[35%]">Product</th> <!-- Wider column -->
                                    <th class="px-4 py-2">Unit</th>
                                    <th class="px-4 py-2">Qty</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in fd.items" :key="item.product_id"
                                    class="border-t border-gray-200">
                                    <td class="px-4 py-3">{{ item.name }}</td>
                                    <td class="px-4 py-3">
                                        <vue-select v-model="item.unit" :options="listUnits" :closeOnSelect="true"
                                            :searchable="true" :reduce="u => u.id" :label-by="'name'" label="name"
                                            class="db-field-control f-b-custom-select" placeholder="--"
                                            search-placeholder="--" />
                                    </td>
                                    <td class="px-4 py-3">
                                        <input v-on:keypress="floatNumber($event)" v-model="item.qty" type="text"
                                            min="1" class="db-field-control w-full">
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button @click="removeItem(index)">
                                            <i class="lab lab-close !text-2xl"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>

                    <div class="form-col-12">
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
import SmSidebarModalCreateComponent from "../components/buttons/SmSidebarModalCreateComponent";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import LoadingComponent from "../components/LoadingComponent";
import alertService from "../../../services/alertService";
import appService from "../../../services/appService";

export default {
    name: "PurchaseOrdersCreateComponent",
    components: { SmSidebarModalCreateComponent, LoadingComponent, Datepicker },
    // props: ["props"],
    props: {
        props: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            fd: {
                date: '',
                supplier_id: null,
                branch_id: null,
                items: [],
            },
            selectedProduct: null,
            errors: {},
        };
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_purchase_orders") }
        },

        listBranchs() {
            return this.$store.getters['product/listBranchs'];
        },
        listUnits() {
            return this.$store.getters['product/listUnits'];
        },
        listProducts() {
            return this.$store.getters['product/listProducts'];
        },
        listSuppliers() {
            return this.$store.getters['product/listSuppliers'];
        },
        filteredProductOptions() {
            return this.listProducts.filter(p =>
                !this.fd.items.some(item => item && item.product_id === p.id)
            );
        }
    },
    watch: {
        // props: {
        //     handler(state) {
        //         if (state.form) {
        //             this.fd = state.form;
        //         }
        //     },
        //     deep: true,
        // },
        props: {
            handler(newProps) {
                if (newProps && newProps.form) {
                    this.fd = { ...newProps.form }; // Make a shallow copy to avoid reference issues
                }
            },
            deep: true, // Ensures we watch changes within nested objects (like form)
        },
    },
    mounted() {
        this.getCurrentDateTime();
        this.fetchSuppliers();
        this.fetchBranchs();
        this.fetchUnits();
        this.fetchProducts();
    },
    methods: {
        getCurrentDateTime: function () {
            const now = new Date();
            this.fd.date = now;
        },
        fetchSuppliers: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listSuppliers').then(res => {
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
        fetchBranchs: function () {
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
        fetchUnits: function () {
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
        fetchProducts: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('product/listProducts').then(res => {
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
        floatNumber(e) {
            return appService.floatNumber(e);
        },
        onProductSelect(product) {
            if (!product) return;
            if (product && product.id) {
                this.fd.items.unshift({
                    product_id: product.id,
                    name: product.name,
                    unit: '',
                    qty: 1
                });
            }
            console.log(this.fd.items);

            this.selectedProduct = null;
        },
        removeItem(index) {
            this.fd.items.splice(index, 1);
        },
        reset: function () {
            appService.sideDrawerHide();
            this.$store.dispatch("purchaseOrders/reset").then().catch();
            this.errors = {};
            this.fd = {
                date: '',
                supplier_id: null,
                branch_id: null,
                items: [],
            };
            this.getCurrentDateTime()
        },

        save: function () {
            const payload = {
                ...this.fd,
                date: new Date(this.fd.date).toISOString().slice(0, 19).replace('T', ' '),
                items: this.fd.items.map(item => ({
                    product_id: item.product_id,
                    unit: item.unit.id,
                    qty: item.qty,
                }))
            };
            console.log(payload);
            try {
                const tempId = this.$store.getters["purchaseOrders/temp"].temp_id;
                // this.loading.isActive = true;
                this.$store
                    .dispatch("purchaseOrders/save", {
                        form: payload,
                        search: this.props.search,
                    })
                    .then((res) => {
                        appService.sideDrawerHide();
                        this.loading.isActive = false;
                        alertService.successFlip(tempId === null ? 0 : 1, this.$t("menu.purchase_orders"));
                        this.fd = {};
                        this.errors = {};
                    })
                    .catch((err) => {
                        this.loading.isActive = false;
                        this.errors = err.response.data.errors;
                    });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },
    },
};
</script>
