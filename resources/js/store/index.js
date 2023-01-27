import { createStore } from 'vuex'

const store = createStore({
    state () {
      return {
        counter: 1000,
        user:{
            "src": "https://cdn.vuetifyjs.com/images/john.jpg",
            "alt": "John"
        },
        isAutheticated: false
      }
    },
    getters:{
        GET_COUNTER(state){
            return state.counter;
        },
        GET_USER(state){
            return state.user;
        },
        GET_IS_AUTHENTICATED(state){
            return state.isAutheticated;
        },
    },
    mutations:{
        MUTATE_COUNTER(state, payload) {
            state.counter += payload;
        },
        MUTATE_USER(state, payload) {
            state.user = payload
        },
        MUTATE_IS_AUTHENTICATED(state, payload) {
            state.isAutheticated = payload
        },
    },
    actions:{
        UPDATE_COUNTER({ commit }, payload){
            commit('MUTATE_COUNTER', payload);
        },
        UPDATE_USER({ commit }, payload) {
            commit('MUTATE_USER', payload);
        },
        UPDATE_IS_AUTHENTICATED({ commit }, payload) {
            commit('MUTATE_IS_AUTHENTICATED', payload);
        }
    }
})

export default store