import router from '../../router/index.js';


const state ={
	token: localStorage.getItem('access_token') || null,
	error: null
}
const getters = {
	loggedIn(state)
	{
		return state.token !== null;
	},
	allErrors(state)
	{
		console.log(state.error);
	}
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
	formclear() {
        $('#username').val('');
        $('#password').val(''); 
        $('#mainerror').html('');
        $('#usernameerror').html('');
        $('#passworderror').html('');
    },
	userlogin({commit},data){

		axios.post('/api/v1/login',data).then((res)=>{
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
	},
	logout({commit}){
		localStorage.removeItem('user_details');
		localStorage.removeItem('access_token');
		commit('removeToken');
		router.push('/').catch(()=>{});
	}
}

export default {
  state,
  getters,
  actions,
  mutations
};