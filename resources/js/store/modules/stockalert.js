import axios from "axios";
import appService from "../../services/appService";

export const stockalert = {
    namespaced: true,
    state: {
        lists: [],
        counts: null,
        page: {},
        pagination: [],
        show: {},
        temp: {
            temp_id: null,
            isEditing: false,
        },
    },
    getters: {
        lists: function (state) {
            return state.lists;
        },
        counts: function (state) {
            return state.counts;
        },
        pagination: function (state) {
            return state.pagination
        },
        page: function(state) {
            return state.page;
        },
    },
    actions: {
        lists: function(context, payload = {}) {
            return new Promise((resolve, reject) => {
                let url = 'admin/stockalert';
                if (payload) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if(typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit('lists', res.data.data.data);
                        context.commit('page', res.data.data);
                        context.commit('pagination', res.data);
                        context.commit('counts', res.data.count);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
    },
    mutations: {
        lists: function (state, payload) {
            state.lists = payload
        },
        counts: function (state, payload) {
            state.counts = payload
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

    }
}
