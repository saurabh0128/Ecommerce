import axios from  'axios';

const state = {
	products:[]
}

const getters ={
	allProduct: state => state.products	
}

const actions ={
	async getProducts(){
		const productsData = axios.get('/api/v1/product',{
			params:{'access_token': localStorage.getItem('access_token')}
		});
		commit('setProduct',productsData.data); 
	}
}


const mutations = {
	setProduct: (state,products) => state.products = products
}


export default {
  state,
  getters,
  actions,
  mutations
};