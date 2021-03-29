import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
    categories: [],
    products: []
}

const getters = {
    categories: state => state.categories,
    products: state => state.products,
}

const mutations = {
    setCategories: (state, categories) => {
        state.categories = categories
    },
    setProducts: (state, products) => {
        state.products = products
    },
}

const actions = {}

export default new Vuex.Store({
    state: state,
    getters: getters,
    actions: actions,
    mutations: mutations
})