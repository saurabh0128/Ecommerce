import axios from  'axios';

// axios.defaults.headers.common = {'Authorization': `Bearer `+ localStorage.getItem('access_token')}

const state = {
	products:[]
}

const getters ={
	allProduct: state => state.products	
}

const actions ={
	async getProducts({ commit },sortdata =1 ){
		// console.log(sortdata)
		axios.get('/api/v1/product', { params:{ 'sorting': sortdata }} ).then((res)=>{
			if(res.data.status)
			{
				commit('setProduct',res.data.product);
			}
		});
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