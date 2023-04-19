// Import any necessary modules here

// Define the cart store module
export default {
    namespaced: true,

    // Define the initial state of the cart
    state: {
        added: [],
    },

    // Define the mutations that can modify the state
    mutations: {
        ADD_TO_CART(state, product) {
            const productInCart = state.added.find(item => item.id === product.id)

            if (!productInCart) {
                state.added.push({
                    ...product,
                    quantity: 1
                })
            } else {
                productInCart.quantity++
            }
        },

        REMOVE_FROM_CART(state, item) {
            const index = state.added.findIndex(product => product.id === item.id)
            const productInCart = state.added[index]

            if (productInCart.quantity > 1) {
                productInCart.quantity--
            } else {
                state.added.splice(index, 1)
            }
        },
    },

    // Define the getters that can retrieve data from the state
    getters: {
        cartProducts(state) {
            return state.added
        },
        addedCount(state) {
            return state.added.reduce((count, product) => count + product.quantity, 0)
        }
    },
}
