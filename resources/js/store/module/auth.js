import router from '../../router/index.js';
import axios from  'axios';

axios.defaults.headers.common = {'Authorization': `Bearer `+ localStorage.getItem('access_token')}

const state ={
	token: localStorage.getItem('access_token') || null,
	error: null
}
const getters = {
	loggedIn: state => state.token !== null,
	allErrors : state => state.error
}
const mutations = {
	setToken(state , token){
		state.token = token
	},
	removeToken(state , token){
		state.token = null
	},
	setError(state , errors){
		state.error = errors
	},
	removeError(state,errors)
	{
		state.error = null
	}
}
const actions = {
	async userLogin({commit},loginData){
		await axios.post('/api/v1/login',loginData).then((res)=>{
            if(res.data.status)
            {
                $('.login-box').hide();
                $('.login-modal-bg').hide();
                $('body').css("overflow-y",'auto');
                localStorage.setItem('user_details',JSON.stringify(res.data.info));
 	 			localStorage.setItem('access_token',res.data.access_token);
 	 			commit('setToken',res.data.access_token);
				commit('removeError');    
            }   
            else 
            {
                commit('setError',res.data.error);
            } 
        })

		if(localStorage.getItem('cartProductData') && localStorage.getItem('access_token') )
		{
			var CartProductArr = localStorage.getItem('cartProductData').split('|');
	        // await CartProductArr.forEach(function(product){
	        await axios.post('/api/v1/cart',{'productData':CartProductArr},
	        {headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
	        	if(res.data.status)
	        	{
	        		localStorage.removeItem('cartTotal');
	        		localStorage.removeItem('cartProductData');		
	        	}
	        });
	        // });
		}
	},
	logout({commit}){
		localStorage.removeItem('user_details');
		localStorage.removeItem('access_token');
		commit('removeToken');
		router.push('/').catch(()=>{});
	},
	async userRegister({commit},userRegisterData){
 		return await axios.post('/api/v1/registration',userRegisterData).then((res)=>{
            if(res.data.status)
            {
                commit('removeError');
                return {'status':true};
            }
            else{
                commit('setError',res.data.error);
                return {'status':false};
            }     
        })
	},
	async sellerRegister({commit},sellerRegisterData){
		return await axios.post('/api/v1/registration',sellerRegisterData).then((res)=>{
            if(res.data.status)
            {
               commit('removeError');
               return {'status':true};
            }
            else{
                commit('setError',res.data.error);
                return {'status':false};
            }     
        })
	}
}

export default {
  	state,
  	getters,
  	actions,
  	mutations
};