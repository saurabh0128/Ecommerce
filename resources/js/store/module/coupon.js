import axios from 'axios';

const state ={
	discount:null,
	coupon:null
}

const getters ={
totalDiscount : state => state.discount,
getCoupon : state =>state.coupon
}

const actions ={
	async addCoupon({commit},coupon){
		await axios.post('/api/v1/coupon',{'coupon_code':coupon},{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			if(res.data.status)
			{
				commit('setDiscount',res.data.discount);
				commit('setCoupon',coupon);
			}
			else{
				console.log(res.data.error)
			}	
		});
	},
	async rmvCoupan({commit}){
		await axios.delete('/api/v1/coupon/'+ state.coupon,{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}})
		commit('removeDiscount');
		commit('removeCoupon');
	},
	async getAllCouponData({commit})
	{
		await axios.get('/api/v1/coupon',{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			if(res.data.status)
			{
				commit('setDiscount',res.data.coupon_data.discount);
				commit('setCoupon',res.data.coupon_data.coupon_code);
			}
		});
	}

} 

const mutations ={
	setDiscount: (state,discount) => state.discount = discount,
	setCoupon:(state,coupon) => state.coupon = coupon,
	removeDiscount:(state) => state.discount = 0,
	removeCoupon:(state) => state.coupon = null
}

export default{
	state,
	getters,
	actions,
	mutations
}