import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '../store/auth'
import cart from '../store/cart'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        cart
    }
})

export default store
