import axios from 'axios';

const state = {
	categorys:[]
}

const getters ={
	allCategory: state => state.categorys	
}

const actions ={
	async getCategory({ commit }) {
		await axios.get('/api/v1/category').then((res)=>{
			if(res.data.status)
			{
				commit('setCategory',res.data.category);
			}
		});
	}
}


const mutations = {
	setCategory: (state,category) => state.categorys = category
}


export default {
  state,
  getters,
  actions,
  mutations
};