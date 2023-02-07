import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state () {
      return {
        user: {},
        role: 'User',
        permission: {},
        isAutheticated: false,
        alert: {
            value: false,
            type: 'success',
            text: '',
        }
      }
    },
    getters:{
        GET_USER(state) {
            return state.user
        },
        GET_ROLE(state) {
            return state.role
        },
        GET_PERMISSION(state) {
            return state.permission
        },
        GET_IS_AUTHENTICATED(state) {
            return state.isAutheticated
        },
        GET_ALERT(state) {
            return state.alert;
        },
    },
    mutations:{
        MUTATE_USER(state, payload) {
            state.user = payload
        },
        MUTATE_ROLE(state, payload) {
            state.role = payload
        },
        MUTATE_PERMISSION(state, payload) {
            state.permission = payload
        },
        MUTATE_IS_AUTHENTICATED(state, payload) {
            state.isAutheticated = payload
        },
        MUTATE_ALERT(state, payload) {
            state.alert = payload
        },
    },
    actions:{
        UPDATE_USER({ commit }, payload) {
            commit('MUTATE_USER', payload)
        },
        RESET_USER({ commit }) {
            commit('MUTATE_USER', {})
            commit('MUTATE_ROLE', 'User')
            commit('MUTATE_PERMISSION', {})
            commit('MUTATE_IS_AUTHENTICATED', false)
        },
        UPDATE_ROLE({ commit }, payload) {
            commit('MUTATE_ROLE', payload)
        },
        UPDATE_PERMISSION({ commit }, payload) {
            commit('MUTATE_PERMISSION', payload)
        },
        UPDATE_IS_AUTHENTICATED({ commit }, payload) {
            commit('MUTATE_IS_AUTHENTICATED', payload)
        },
        UPDATE_ALERT({ commit }, payload) {
            commit('MUTATE_ALERT', payload)
            setTimeout(() => {
                commit('MUTATE_ALERT', {
                    value: false,
                    type: 'success',
                    text: '',
                })
            }, 2700)
        },
    },

    plugins: [createPersistedState()]
})

export default store