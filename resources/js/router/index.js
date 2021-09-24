import Vue from 'vue'; 
import VueRouter from "vue-router";
import Login from '../components/auth/login.vue';	
import Register from '../components/auth/register.vue';
import Home from '../components/view/Home.vue';
import Shop from '../components/view/Shop.vue';
import ProductDetails from '../components/view/ProductDetails.vue';
import wishlist from '../components/view/Wishlist.vue';
import AboutUs from '../components/view/AboutUs.vue';
import ContactUs from '../components/view/ContactUs.vue';
import Cart from '../components/view/Cart.vue';
import Faq from '../components/view/Faq.vue';
import page404 from	 '../components/view/404.vue';
import MyAccount from '../components/view/MyAccount.vue';
import store from '../store/index.js';
import checkout from '../components/view/checkout.vue';


Vue.use(VueRouter);



const router = new VueRouter({
mode: 'history',
 routes:[
		{
			path:'/',
			name:'home',
			component:Home	
		},
		{
			path:'/shop',
			name:'shop',
			component:Shop
		},
		{
			path:'/login',
			name:'login',
			component:Login
		},
		{
			path:'/register',
			name:'register',
			component:Register
		},
		{
			path:'/product/:ProductName',
			name:'product_info',
			component:ProductDetails
		},
		{
			path:'/wishlist',
			name:'wishlist',
			component:wishlist
		},
		{
			path:'/aboutus',
			name:'aboutus',
			component:AboutUs
		},
		{
			path:'/contactus',
			name:'contactus',
			component:ContactUs
		},
		{
			path:'/cart',
			name:'cart',
			component:Cart
		},
		{
			path:'/faq',
			name:'faq',
			component:Faq
		},
		{
			path:'/account',
			name:'my_account',
			component:MyAccount,
			meta:{
				requiresAuth:true
			}

		},
		{
			path:'/checkout',
			name:'checkout',
			component:checkout
		},
		{
			path:'*',
			name:'not found',
			component:page404
		}
	],
	linkExactActiveClass: "active"
});



router.beforeEach((to, from, next) =>{
    if (to.matched.some(record =>record.meta.requiresAuth)){
    	if(!store.getters.loggedIn)
    	{
    		next({
 				name:'home' 			
    		})
    	}
    	else{
    		next()
    	}
    }else{
    	next()
    }
});

export default router;