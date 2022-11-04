import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import store from '@/store/store'

export default createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        store
    }
})

