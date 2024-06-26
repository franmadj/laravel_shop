import router from '../router'
export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {}
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        }
    },
    actions: {
        login({ commit }) {
            return axios.get('/api/user').then(({ data }) => {
                    console.log(data.data);
                    commit('SET_USER', data.data)
                    commit('SET_AUTHENTICATED', true)
                    window.location.href = "/admin"
                    router.push({ name: 'Dashboard' })
                })
                .catch(({ error }) => {
                    console.log('catch', error);
                    commit('SET_USER', {})
                    commit('SET_AUTHENTICATED', false)
                })
        },
        logout({ commit }) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
            window.location.href = "/login"
        },
        clearStorage({ commit }) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
        }
    }
}