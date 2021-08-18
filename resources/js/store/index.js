import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router/index.js'
import product from  './module/products.js'

Vue.use(Vuex);


export default new Vuex.Store({
	state:{
		token: localStorage.getItem('access_token') || null
	},
	getters:{
		loggedIn(state)
		{
			return state.token !== null;
		}
	},
	mutations:{
		setToken(state , token){
			state.token = token
		},
		removeToken(state , token){
			state.token = null
		}
	},
	actions:{
		login(context,data){
			
			localStorage.setItem('user_details',JSON.stringify(data.info));
            localStorage.setItem('access_token',data.access_token);
			context.commit('setToken',data.access_token);
		},
		logout(context){
			localStorage.removeItem('user_details');
			localStorage.removeItem('access_token');
			context.commit('removeToken');
			router.push('/').catch(()=>{});
		}


	},
	modules:{
		product
	}

})



