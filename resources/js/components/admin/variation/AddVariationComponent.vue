<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer max-w-[30rem]">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.variation") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">{{ $t("label.name") }}</label>
                        <input v-model="fd.name" v-bind:class="errors.name ? 'invalid' : ''" type="text" id="name"
                            class="db-field-control">
                        <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small>
                    </div>
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">Variation Types:</label>
                        <div class="flex gap-3">
                            <input v-model="oldVariationType" type="text" id="type" class="db-field-control">
                            <div @click="add" class="bg-primary text-white px-3 py-2 rounded cursor-pointer">
                                <i class="lab lab-add-circle-line"></i>
                            </div>
                        </div>
                        <div v-for="(item, index) in fd.type" :key="index" class="flex gap-3 mt-5">
                            <input type="text" v-model="item.name" class="db-field-control">
                            <div @click="remove(index)" class="bg-red-500 text-white px-3 py-2 rounded cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </div>
                        </div>
                        <small class="db-field-alert" v-if="errors.type">{{ errors.type[0] }}</small>
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
                id: "",
                name: "",
                type: [],
            },
            errors: {},
            oldVariationType: "",
        }
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_variation") }
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

    mounted() {

    },
    methods: {
        reset: function () {
            appService.sideDrawerHide();
        },

        add: function () {
            this.fd.type.push({ id: null, name: '' });
        },

        remove: function (index) {
            this.fd.type.splice(index, 1);
        },

        save: function () {
            try {
                // If there's an old variation type, add it to fd.type
                if (this.oldVariationType) {
                    this.fd.type.push({ id: null, name: this.oldVariationType });
                    this.oldVariationType = "";
                }
                const tempId = this.$store.getters['variation/temp'].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch('variation/save', {
                    form: {
                        ...this.fd,
                        type: this.fd.type // This will include id and name for each type
                    },
                    search: this.props.search
                }).then((res) => {
                    appService.sideDrawerHide();
                    this.loading.isActive = false;
                    alertService.successFlip((tempId === null ? 0 : 1), this.$t('menu.variations'));
                    this.errors = {};
                    this.fd = {
                        id: "",
                        name: "",
                        type: [],
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
