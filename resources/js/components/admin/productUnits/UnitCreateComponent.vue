<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer max-w-[30rem]">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.unit") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">{{ $t("label.name") }}</label>
                        <input v-model="fd.name" v-bind:class="errors.name ? 'invalid' : ''" type="text"
                            id="name" class="db-field-control">
                        <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small>
                    </div>
                    <div class="col-12">
                        <label class="db-field-title">{{ $t("label.status") }}</label>
                        <div class="db-field-radio-group">
                            <div class="db-field-radio">
                                <div class="custom-radio">
                                    <input type="radio" id="active" v-model="fd.status" value="Active" class="custom-radio-field">
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="active" class="db-field-label">{{ $t('label.active') }}</label>
                            </div>
                            <div class="db-field-radio">
                                <div class="custom-radio">
                                    <input type="radio" class="custom-radio-field" v-model="fd.status" value="Inactive" id="inactive">
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="inactive" class="db-field-label">{{ $t('label.inactive') }}</label>
                            </div>
                        </div>
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
                status: "Active",
            },
            errors: {},
        }
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_unit") }
        },
    },
    watch: {
        'props.form': {
            handler(state) {
                if (state) {
                    this.fd = {
                        id: state.id,
                        name: state.name,
                        status: state.status,
                    };
                }
            },
            deep: true
        }
    },
    methods: {
        reset: function() {
            appService.sideDrawerHide();
            this.$store.dispatch('unit/reset').then().catch();
            this.errors = {};
            this.$props.props.form = {
                name: "",
                status: "Actice"
            };
        },

        save: function() {
            try {
                const tempId = this.$store.getters['unit/temp'].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch('unit/save', {
                    form: this.fd,
                    search: this.props.search
                }).then((res) => {
                    appService.sideDrawerHide();
                    this.loading.isActive = false;
                    alertService.successFlip((tempId === null ? 0 : 1), this.$t('menu.unit'));
                    this.errors = {};
                    this.fd = {
                        name: "",
                        staus: "Actice"
                    };
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = {};
                    if (err.response && err.response.data && err.response.data.errors) {
                        this.errors = err.response.data.errors;
                    } else {
                        alertService.error(err.response.data.message);
                    }
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err)
            }
        }
    }
}
</script>
