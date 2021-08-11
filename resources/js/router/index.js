import Vue from 'vue';
import VueRouter from "vue-router";
import Login from '../components/auth/login.vue';	
import Register from '../components/auth/register.vue';
import Home from '../components/view/home.vue';
import Shop from '../components/view/shop.vue';


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
		}
	]

});

// router.beforeEach((to, from, next) =>
//     Promise.all([store.dispatch("auth/checkAuth")]).then(next)
// );

export default router;