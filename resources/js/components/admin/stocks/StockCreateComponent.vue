<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer max-w-[30rem]">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.stock") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form >
                <div class="form-row">
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">{{ $t("label.name") }}</label>
                        <input type="text"
                            id="name" class="db-field-control">
                        <!-- <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </div>
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">Categories</label>
                        <input type="text"
                            id="name" class="db-field-control">
                        <!-- <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </div>
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">Quantity</label>
                        <input type="text"
                            id="name" class="db-field-control">
                        <!-- <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </div>
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">Price</label>
                        <input type="text"
                            id="name" class="db-field-control">
                        <!-- <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </div>
                    <div class="form-col-12">
                        <label for="name" class="db-field-title required">Status</label>
                        <!-- <input type="text"
                            id="name" class="db-field-control"> -->
                        <!-- <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small> -->
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

        }
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_stock") }
        },
    },

    mounted() {

    },
    methods: {
        reset: function() {
            appService.sideDrawerHide();
        },
    }
}
</script>
