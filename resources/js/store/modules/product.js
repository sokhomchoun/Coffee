import axios from "axios"
import appService from "../../services/appService"

export const product = {
    namespaced: true,
    state: {
        lists: [],
        page: {},
        pagination: [],
        listBrands: [],
        listUnits: [],
        listBranchs: [],
        listCategories: [],
        listProducts: [],
        listSuppliers: [],
        show: {},
        temp: {
            temp_id: null,
            isEditing: false,
        },
    },
    getters: {
        listBrands: function (state) {
            return state.listBrands;
        },
        listUnits: function (state) {
            return state.listUnits;
        },
        listBranchs: function (state) {
            return state.listBranchs;
        },
        listCategories: function (state) {
            return state.listCategories;
        },
        listProducts: function (state) {
            return state.listProducts;
        },
        listSuppliers: function (state){
            return state.listSuppliers;
        },
        lists: function (state) {
            return state.lists;
        },
        pagination: function (state) {
            return state.pagination
        },
        page: function(state) {
            return state.page;
        },
        temp: function (state) {
            return state.temp;
        }
    },
    actions: {
        listBrands: function(context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/brand-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listBrands', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        listUnits: function (context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/product-unit-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listUnits', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        listBranchs: function (context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/branch-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listBranchs', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        listCategories: function (context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/category-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listCategories', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        listProducts: function (context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/product-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listProducts', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        listSuppliers: function (context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/product/supplier-list';
                if (Object.keys(payload).length > 0) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('listSuppliers', res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        lists: function(context, payload) {
            return new Promise((resolve, reject) => {
                let url = '/admin/product';
                if (payload) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('lists', res.data.data);
                        context.commit('page', res.data.meta);
                        context.commit('pagination', res.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        save: function(context, payload) {
            return new Promise((resolve, reject) => {
                let method = axios.post;
                let url = '/admin/product';
                if (this.state['product'].temp.isEditing && this.state['product'].temp.id) {
                    method = axios.post;
                    url = `/admin/product/${this.state['product'].temp.id}`;
                }
                method(url, payload.form).then(res => {
                    context.dispatch('lists', payload.search).then().catch();
                    context.commit('reset');
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        edit: function (context, payload) {
            context.commit('temp', payload);
        },
        reset: function (context) {
            context.commit('reset');
        },
        destroy: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`admin/product/${payload.id}`).then((res) => {
                    context.dispatch('lists', payload.search).then().catch();
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },

    },

    mutations: {
        listBrands: function (state, payload) {
            state.listBrands = payload
        },
        listUnits: function (state, payload) {
            state.listUnits = payload;
        },
        listBranchs: function (state, payload) {
            state.listBranchs = payload;
        },
        listCategories: function (state, payload) {
            state.listCategories = payload;
        },
        listProducts: function (state, payload) {
            state.listProducts = payload;
        },
        listSuppliers: function (state, payload){
            state.listSuppliers = payload;
        },
        lists: function (state, payload) {
            state.lists = payload
        },
        pagination: function (state, payload) {
            state.pagination = payload;
        },
        page: function (state, payload) {
            if(typeof payload !== "undefined" && payload !== null) {
                state.page = {
                    from: payload.from,
                    to: payload.to,
                    total: payload.total
                }
            }
        },
        temp: function (state, payload) {
            state.temp = payload;
            state.temp.isEditing = true;
        },
        reset: function(state) {
            state.temp.temp_id = null;
            state.temp.isEditing = false;
        }
    }
}
