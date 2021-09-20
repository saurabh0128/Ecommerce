import axios from  'axios';
// axios.defaults.headers.common = {'Authorization': `Bearer `+ localStorage.getItem('access_token')}

const state = {
	cart:[],
	totalPrice:0
}

const getters ={
	// get all cart Details
	allCart: state => state.cart,
	//total price of all product
	tPrice : state => state.totalPrice,
	//get a details of user logged in or not
	logedingetter(state, getters, rootGetters){
	 return getters.loggedIn;
	}
}

const actions ={
	//get a two details from front site product id and qty
	async addCartProduct({ commit },{product_id,qty}){
			// parameter all Product data assighn to a variable 
		var AllProductData = { 'id':product_id ,'quantity':qty };
		// call a add to cart method using axios and pass cart data with authentication berar
		await axios.post('/api/v1/cart',{'productData':AllProductData},{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
			// get a response from axios request if user logged in status return true otherwise false
			if(res.data.status)
			{
				//change karvanu 6a
				console.log(res.data.status);
			}
			else{
				// get a all cart Product Details from local storage
				var productData = localStorage.getItem('cartProductData');
				var fProductData ='';
				// get total of all cart product
				var totalPrice = localStorage.getItem('cartTotal')? parseInt(localStorage.getItem('cartTotal')) : 0;

				//create a new cart if not exist other wise update old cat
				if(productData)
				{
					// all product data convert into array seprate from '|'
					var ProductArr = productData.split('|');
					var ProductExist = 0;
					var ProductObj = {};
					var BreakException = {};
					var ProductQty = 0;
					var ProductPrice =0;
					try{
						//Update Old Product Qty other insert new product in cart
						ProductArr.forEach(function(product){
							ProductObj = JSON.parse(product);	
							if(ProductObj.id == res.data.productData.id)
							{
								ProductQty = ProductObj.quantity;
								ProductPrice =  ProductObj.price; 
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
					
					//Update old Product and add into localstorage
					if(ProductExist == 0)
					{
						var NewProdutcString = '';
						// count product subtotal
						res.data.productData.subTotal = res.data.productData.price * res.data.productData.quantity;
						
						//if it only one product not require '|' if multiple then required 
						if(ProductArr.length == 0)
						{
							NewProdutcString = ProductArr.join('|') + JSON.stringify(res.data.productData);	
						}
						else
						{
							NewProdutcString = ProductArr.join('|') + '|' + JSON.stringify(res.data.productData);
						}

						//Add new strinh to fproductdata for store in localstorage  
						fProductData += NewProdutcString;

						// calculate total price as per increment or decrement of qty
						if(ProductQty > res.data.productData.quantity)
						{
							ProductQty -= res.data.productData.quantity;
							totalPrice -= ProductPrice * ProductQty;
						}
						else if(ProductQty < res.data.productData.quantity)
						{
							ProductQty = res.data.productData.quantity - ProductQty;
							totalPrice += ProductPrice * ProductQty;
						} 

					}
					else{
						// goto else when product not exist
						fProductData += productData;
						res.data.productData.subTotal = res.data.productData.price * res.data.productData.quantity;
						fProductData += '|' + JSON.stringify(res.data.productData);
						totalPrice   +=  res.data.productData.price * res.data.productData.quantity; 
					}
				}	
				else{	
					// goto else when cart not exist
					res.data.productData.subTotal  =  res.data.productData.price * res.data.productData.quantity;
					fProductData  += JSON.stringify(res.data.productData);
					totalPrice    += res.data.productData.price * res.data.productData.quantity; 
				}
				// set cart product and total price in local storage
				localStorage.setItem('cartProductData', fProductData);
				localStorage.setItem('cartTotal',totalPrice);

				//store data in json format in vuex store 
				var cartproductres = fProductData.split('|');
				cartproductres.forEach(function(product, index) {
				  this[index] = JSON.parse(product);
				}, cartproductres);

				commit('setCart',cartproductres);
				commit('setTotalPrice',totalPrice);
			}
		});
	},
	getCart({commit ,getters }){
		// get all cart data from database and commit into vuex store
		if(getters.logedingetter)
		{			
			axios.get('/api/v1/cart',{headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
				if(res.data.status)
				{
					var dbCartProduct = res.data.cart.cart_item;
					dbCartProduct.forEach(function(dbproduct, index) {
			  		dbproduct['subTotal'] = dbproduct.price * dbproduct.quantity;
					}, dbCartProduct);
					commit('setCart',dbCartProduct);
				}
			});
		}
		//  get all data from localstorage and commit into vuex store
		else if(localStorage.getItem('cartProductData'))
		{
			var productres = localStorage.getItem('cartProductData').split('|');
			var productTotal = localStorage.getItem('cartTotal');
			productres.forEach(function(product, index) {
			  this[index] = JSON.parse(product);
			}, productres);
			commit('setCart',productres);	
			commit('setTotalPrice',productTotal);
		}
		else{
			commit('setCart',[]);
		}

	},
	//remove cart product
	 removeCartProduct({commit , getters},id){
	 	if(getters.logedingetter)
	 	{
		 	axios.delete('/api/v1/cart/'+id,{headers:{'Authorization': `Bearer`+ localStorage.getItem('access_token')}});
	 	}
	 	else{
	 		var AllCartProduct = localStorage.getItem('cartProductData').split('|');
	 		var ProductSubTotal = 0;   
	 		AllCartProduct.forEach(function(product, index) {
			  this[index] = JSON.parse(product);
			},AllCartProduct);
	 		
	 		AllCartProduct.forEach(function(product,index){
	 			if(product.id == id)
	 			{	
	 				AllCartProduct.splice(AllCartProduct.indexOf(product),1);
	 				ProductSubTotal = product.price * product.quantity;
	 			} 
	 		});

	 		AllCartProduct.forEach(function(product,index){	
	 			this[index] =  JSON.stringify(product); 
	 		},AllCartProduct);

	 		ProductSubTotal = localStorage.getItem('cartTotal') - ProductSubTotal;

	 		localStorage.setItem('cartTotal',ProductSubTotal);
	 		localStorage.setItem('cartProductData',AllCartProduct.join('|'));
	 	}
	},
	async updateCartProduct({commit},allUpdateProduct){
		if(getters.logedingetter)
		{
			await axios.post('/api/v1/cart',{'productData':allUpdateProduct},
	        {headers:{'Authorization': `Bearer `+ localStorage.getItem('access_token')}}).then((res)=>{
	        	console.log(res.data);
	        });
		}	
		else
		{
			var CartSubTotal = 0; 
			var newUpdatedProduct = [];		 
			commit('setCart',allUpdateProduct);
			allUpdateProduct.forEach(function(product,index){
					CartSubTotal  +=	 product.subTotal;
		 			this[index] =  JSON.stringify(product); 
		 	},newUpdatedProduct);
			localStorage.setItem('cartProductData',newUpdatedProduct.join('|'));
			localStorage.setItem('cartTotal',CartSubTotal);
		}	
			commit('setTotalPrice',CartSubTotal);
	},
	async clearCartProduct({commit,getters}){
	 	if(getters.logedingetter && getters.allCart.length)
	 	{
	 		await axios.delete('/api/v1/cart/'+getters.allCart[0].cart_id,{headers:{'Authorization': `Bearer`+ localStorage.getItem('access_token')},params:{type:'cart'}});
	 	}
	 	else{
	 		localStorage.removeItem('cartProductData');
	 		localStorage.removeItem('cartTotal');
	 	}
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