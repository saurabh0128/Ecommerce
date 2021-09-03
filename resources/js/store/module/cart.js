import axios from  'axios';

axios.defaults.headers.common = {'Authorization': `Bearer `+ localStorage.getItem('access_token')}

const state = {
	cart:[],
	totalPrice:0
}

const getters ={
	allCart: state => state.cart,
	tPrice : state => state.totalPrice
}

const actions ={
	async addCartProduct({ commit },{product_id,qty}){
		var AllProductData = { 'id':product_id ,'qty':qty };
		await axios.post('/api/v1/cart',{'productData':AllProductData}).then((res)=>{
			if(res.data.status)
			{
				console.log(res.data.status);
			}
			else{
				var productData =localStorage.getItem('cartProductData');
				var fProductData ='';
				var totalPrice = localStorage.getItem('cartTotal')? parseInt(localStorage.getItem('cartTotal')) : 0;
				if(productData)
				{
					var ProductArr = productData.split('|');
					var ProductExist = 0;
					var ProductObj = {};
					var BreakException = {};
					var ProductQty = 0;
					var ProductPrice =0;
					try{	
						ProductArr.forEach(function(product){
							ProductObj = JSON.parse(product);
							
							if(ProductObj.id == res.data.productData.id)
							{
								ProductQty = ProductObj.qty;
								ProductPrice = ProductObj.special_price? ProductObj.special_price: ProductObj.current_price; 
								var ProductArrIndex = ProductArr.indexOf(product);
								ProductArr.splice(ProductArrIndex, 1);
								ProductExist = 0;
								throw BreakException;
							}
							else{
								ProductExist = 1;
							}
						});
					}catch(e)
					{
						if(e !== BreakException) throw e;
					}
					

					if(ProductExist == 0)
					{
						var NewProdutcString = '';
						res.data.productData.subTotal = res.data.productData.special_price? res.data.productData.special_price * res.data.productData.qty  : res.data.productData.current_price * res.data.productData.qty;
						if(ProductArr.length == 0)
						{
								NewProdutcString = ProductArr.join('|') + JSON.stringify(res.data.productData);	
						}
						else
						{
								NewProdutcString = ProductArr.join('|') + '|' + JSON.stringify(res.data.productData);
						}
						fProductData += NewProdutcString;
						if(ProductQty > res.data.productData.qty)
						{
								ProductQty -= res.data.productData.qty;
								totalPrice -= ProductPrice * ProductQty;
						}
						else if(ProductQty < res.data.productData.qty)
						{
								ProductQty = res.data.productData.qty - ProductQty;
								totalPrice += ProductPrice * ProductQty;
						} 

					}
					else{
						fProductData += productData;
						res.data.productData.subTotal = res.data.productData.special_price? res.data.productData.special_price * res.data.productData.qty  : res.data.productData.current_price * res.data.productData.qty;
						fProductData += '|' + JSON.stringify(res.data.productData);
						totalPrice    += res.data.productData.special_price? res.data.productData.special_price * res.data.productData.qty  : res.data.productData.current_price * res.data.productData.qty; 
					}
				}	
				else{	
					res.data.productData.subTotal  =  res.data.productData.special_price? res.data.productData.special_price * res.data.productData.qty  : res.data.productData.current_price * res.data.productData.qty;
					fProductData  += JSON.stringify(res.data.productData);
					totalPrice    += res.data.productData.special_price? res.data.productData.special_price * res.data.productData.qty  : res.data.productData.current_price * res.data.productData.qty; 
				}
				localStorage.setItem('cartProductData', fProductData);
				localStorage.setItem('cartTotal',totalPrice);
				commit('setCart',fProductData);
				commit('setTotalPrice',totalPrice);
			}
		});
	}
}


const mutations = {
	setCart: (state,cart) => state.cart = cart,
	setTotalPrice:(state,tprice) => state.totalPrice = tprice
}


export default {
  state,
  getters,
  actions,
  mutations
};