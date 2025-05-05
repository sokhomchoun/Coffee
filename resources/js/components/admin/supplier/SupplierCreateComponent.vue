<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.supplier") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12 sm:form-col-6">
                        <label for="name" class="db-field-title required" placeholder="Enter Name">{{ $t("label.name") }}</label>
                        <input v-model="fd.name" v-bind:class="errors.name ? 'invalid' : ''" type="text" id="name"
                            class="db-field-control" />
                        <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="email" class="db-field-title required">{{ $t("label.email") }}</label>
                        <input v-model="fd.email" v-bind:class="errors.email ? 'invalid' : ''" type="text" id="email"
                            class="db-field-control" />
                        <small class="db-field-alert" v-if="errors.email">{{
                            errors.email[0]
                        }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="phone_number" class="db-field-title required">{{
                            $t("label.phone_number")
                        }}</label>
                        <input v-model="fd.phone_number" v-on:keypress="floatNumber($event)"
                            v-bind:class="errors.phone_number ? 'invalid' : ''" type="text" id="phone_number"
                            class="db-field-control" />
                        <small class="db-field-alert" v-if="errors.phone_number">{{ errors.phone_number[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="country" class="db-field-title required">{{
                            $t("label.country")
                        }}</label>
                        <input v-model="fd.country"
                            v-bind:class="errors.country ? 'invalid' : ''" type="text" id="country"
                            class="db-field-control" />
                        <small class="db-field-alert" v-if="errors.country">{{ errors.country[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-12">
                        <label for="city" class="db-field-title required">{{
                            $t("label.city")
                        }}</label>
                        <input v-model="fd.city"
                            v-bind:class="errors.city ? 'invalid' : ''" type="text" id="city"
                            class="db-field-control" />
                        <small class="db-field-alert" v-if="errors.city">{{ errors.city[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-12">
                        <label for="address" class="db-field-title required">{{
                            $t("label.address")
                        }}</label>
                        <textarea v-model="fd.address" v-bind:class="errors.address ? 'invalid' : ''"
                            id="address" class="db-field-control"></textarea>
                        <small class="db-field-alert" v-if="errors.address">{{ errors.address[0] }}</small>
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
    name: "SupplierCreateComponent",
    components: { SmSidebarModalCreateComponent, LoadingComponent, Datepicker },
    props: ["props"],
    data() {
        return {
            loading: {
                isActive: false,
            },
            fd:{},
            errors: {},
        };
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_supplier") }
        },
    },
    watch: {
        props: {
            handler(state) {
                if (state.form) {
                    this.fd = state.form;
                }
            },
            deep: true,
        },
    },
    methods: {
        floatNumber(e) {
            return appService.floatNumber(e);
        },
        reset: function () {
            appService.sideDrawerHide();
            this.$store.dispatch("supplier/reset").then().catch();
            this.errors = {};
            this.fd={};
        },
       
        save: function () {
            try {
                const tempId = this.$store.getters["supplier/temp"].temp_id;
                this.loading.isActive = true;
                this.$store
                    .dispatch("supplier/save", {
                        form: {...this.fd},
                        search: this.props.search,
                    })
                    .then((res) => {
                        appService.sideDrawerHide();
                        this.loading.isActive = false;
                        alertService.successFlip(tempId === null ? 0 : 1, this.$t("menu.supplier"));
                        this.fd={};
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
