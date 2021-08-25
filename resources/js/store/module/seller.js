import axios from 'axios';

const state = {
	sellers:[]
}

const getters ={
	allSeller: state => state.sellers	
}

const actions ={
	async getSeller({ commit }) {
		await axios.get('/api/v1/seller').then((res)=>{
			if(res.data.status)
			{
				commit('setSeller',res.data.seller);
			}
		});
	}
}


const mutations = {
	setSeller: (state,seller) => state.sellers = seller
}


export default {
  state,
  getters,
  actions,
  mutations
};