import axios from  'axios';

// axios.defaults.headers.common = {'Authorization': `Bearer `+ localStorage.getItem('access_token')}

const state = {
	products:[],
	product:''
}

const getters ={
	allProduct: state => state.products,
	singleProduct: state => state.product	
}

const actions ={
	async getProducts({ commit },{filter,pagination }){
		var AllReqestData = Object.assign({},filter,pagination);
		await axios.get('/api/v1/product',{ params:AllReqestData }).then((res)=>{
			if(res.data.status)
			{
				commit('setProduct',res.data.product);
			}
		});
	},
	async getProduct({commit},productId)
	{
		await axios.get('/api/v1/product'+productId).then((res)=>{
				if(res.data.status)
				{
					commit('setSingleProduct',res.data.product);
				}
		});
	},
	getSingleProduct({commit},productData)
	{
			commit('setSingleProduct',productData);
	}
}


const mutations = {
	setProduct: (state,products) => state.products = products,
	setSingleProduct: (state,singelProduct) => state.product = singelProduct
}


export default {
  state,
  getters,
  actions,
  mutations
};