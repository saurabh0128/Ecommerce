import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/index.js'
import product from  './module/products.js'
import login from './module/auth.js'
import category from './module/category.js'
import seller from './module/seller.js'
import cart from './module/cart.js'
import coupon from './module/coupon.js'

Vue.use(Vuex);


export default new Vuex.Store({
	modules:{
		product,
		login,
		category,
		seller,
		cart,
		coupon
	}
})



