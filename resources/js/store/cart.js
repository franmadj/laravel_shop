import router from '../router'
export default {
    namespaced: true,
    state: {
        cartItems: []
    },
    getters: {
        cartItems: state => state.cartItems,
        cartTotal: state => {
            return state.cartItems.reduce((acc, cartItem) => {
                return (cartItem.quantity * cartItem.price) + acc;
            }, 0).toFixed(2);
        },
        cartQuantity: state => {
            return state.cartItems.reduce((acc, cartItem) => {
                return parseInt(cartItem.quantity) + parseInt(acc);
            }, 0);
        }
    },
    mutations: {
        REMOVE_CART_ITEM(state, index) {

            console.log('REMOVE_CART_ITEM', index);

            state.cartItems.splice(index, 1)

        },
        EMPTY_CART(state) {
            state.cartItems = []

        },
        ADD_CART_ITEMS(state, payload) {
            let exists = false;
            //state.cartItems = [];
            console.log('UPDATE_CART_ITEMS', payload, state.cartItems);
            state.cartItems.forEach((item, key) => {
                if (item.id == payload.id) {
                    if (payload.isVariable) {
                        if (item.variation.id == payload.variation.id) {
                            exists = true;
                            state.cartItems[key].quantity = parseInt(state.cartItems[key].quantity) + parseInt(payload.quantity)

                        }
                    } else {
                        exists = true;
                        state.cartItems[key].quantity = parseInt(state.cartItems[key].quantity) + parseInt(payload.quantity)
                    }

                }
            });


            if (!exists)
                state.cartItems.push(payload);

            console.log('UPDAstate.cartItemsTE_CART_ITEMS', state.cartItems);

        }
    },
    actions: {
        getCartItems({ commit }) {
            axios.get('/api/cart').then((response) => {
                commit('UPDATE_CART_ITEMS', response.data)
            });
        },
        addCartItem({ commit }, cartItem) {
            // axios.post('/api/cart', cartItem).then((response) => {
            commit('UPDATE_CART_ITEMS', cartItem)
                // });
        },
        removeCartItem({ commit }, cartItem) {
            axios.delete('/api/cart/delete', cartItem).then((response) => {
                commit('UPDATE_CART_ITEMS', response.data)
            });
        },
        removeAllCartItems({ commit }) {
            axios.delete('/api/cart/delete/all').then((response) => {
                commit('UPDATE_CART_ITEMS', response.data)
            });
        }
    }
}