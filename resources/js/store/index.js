import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/index.js'
import product from  './module/products.js'
import login from './module/auth.js'

Vue.use(Vuex);


export default new Vuex.Store({
	modules:{
		product,
		login
	}

})



