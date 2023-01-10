import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from './auth'
import cart from './cart'
const store = createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        auth,
        cart
    }
})
export default store