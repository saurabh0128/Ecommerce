import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/index.js'
import product from  './module/products.js'
import login from './module/auth.js'
import category from './module/category.js'

Vue.use(Vuex);


export default new Vuex.Store({
	modules:{
		product,
		login,
		category
	}

})



