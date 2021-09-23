import axios from 'axios';

const state ={
	states:null,
	citys:null
}

const getters = {
	allStates :state => state.states,
	allCitys : state => state.citys 
}

const actions = {
	getLocation({commit}){
		axios.get('/api/v1/city').then((res)=>{
			if(res.data.status)
			{
				commit('setCitys',res.data.city_data);
			}
		});

		axios.get('/api/v1/state').then((res)=>{
			if(res.data.status)
			{
				commit('setStates',res.data.state_data);
			}
		});
	},
	selectCity({commit},sId)
	{
		axios.get('/api/v1/city/'+sId).then((res)=>{
			if(res.data.status)
			{
				// console.log(res.data.city_data);
				commit('setCitys',res.data.city_data);
			}
		});
	}
}

const mutations ={
	setStates:(state,states) => state.states = states,
	setCitys:(state,citys) => state.citys = citys
}

export default {
  state,
  getters,
  actions,
  mutations
};