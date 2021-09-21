import axios from 'axios';

const state ={
	discount:0,
	coupon:null
}

const getters ={
totalDiscount : state => state.discount,
getCoupon : state =>state.coupon
}

const actions ={
	async addCoupon({commit},coupon){
		return await axios.post('/api/v1/coupon',{'coupon_code':coupon},{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			if(res.data.status)
			{
				commit('setDiscount',res.data.discount);
				commit('setCoupon',coupon);
				return res.data.success;
			}
			else{
				return res.data.error;
			}	
		});
	},
	async rmvCoupan({commit}){
		return await axios.delete('/api/v1/coupon/'+ state.coupon,{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			if(res.data.status)
			{
				commit('removeDiscount');
				commit('removeCoupon');
				return res.data.success;
			}
		});
	},
	async getAllCouponData({commit})
	{
		await axios.get('/api/v1/coupon',{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			if(res.data.status)
			{
				commit('setDiscount',res.data.coupon_data.discount);
				commit('setCoupon',res.data.coupon_data.coupon_code);
			}
			else
			{
				commit('removeDiscount');
				commit('removeCoupon');
			}
		});
	},
	removeCartProductCoupon({commit},id,price1,qty)
	{

		if(state.coupon)
		{
			axios.put('/api/v1/coupon/'+id,{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')},params:{price:price1}});
		}
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