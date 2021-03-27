import Vue from 'vue'

const getters = {
    products: state => state.products,
}

const mutations = {
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