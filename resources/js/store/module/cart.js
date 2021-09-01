import axios from  'axios';


const state = {
	cart:[]
}

const getters ={
	allCart: state => state.cart
}

const actions ={
	async addCartProduct({ commit }){
		await axios.post('/api/v1/cart').then((res)=>{
			if(res.data.status)
			{
				console.log(res.data.status);
			}
		});
	}
}


const mutations = {
	setCart: (state,cart) => state.cart = cart,
}


export default {
  state,
  getters,
  actions,
  mutations
};