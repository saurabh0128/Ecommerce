import axios from  'axios';


const state = {
	cart:[],
	cartCount:0
}

const getters ={
	allCart: state => state.cart,
	allCartCount : state => state.cartCount
}

const actions ={
	async addCartProduct({ commit },{product_id,qty}){
		var AllProductData = { 'product_id':product_id ,'qty':qty };
		await axios.post('/api/v1/cart',{'productData':AllProductData}).then((res)=>{
			if(res.data.status)
			{
				console.log(res.data.status);
			}
			else{
				var productData =localStorage.getItem('productData');
				var fProductData ='';
				var cartcount = 0;
				if(productData)
				{
					var ProductArr = productData.split(' ');
					var ProductExist = 0;
					var ProductObj = {};
					var BreakException = {};
					try{	
						ProductArr.forEach(function(product){
							ProductObj = JSON.parse(product);
							if(ProductObj.product_id == res.data.productData.product_id)
							{
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
						var NewProdutcString = ProductArr.join(' ') + ' ' + JSON.stringify(res.data.productData);
						fProductData += NewProdutcString;
					}
					else{
						fProductData += productData;
						fProductData += ' ' + JSON.stringify(res.data.productData);
					}
				}	
				else{	
					fProductData += JSON.stringify(res.data.productData);
					cartcount = res.data.productData.qty;
				}
				localStorage.setItem('productData', fProductData);
				commit('setCart',fProductData);
				commit('setCartCount',cartcount);
			}
		});
	}
}


const mutations = {
	setCart: (state,cart) => state.cart = cart,
	setCartCount: (state,count) => state.cartCount = count
}


export default {
  state,
  getters,
  actions,
  mutations
};