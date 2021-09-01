<template>  

<div>	
		<Header/>
		<Login/>
		<router-view></router-view>
		<div id="ak">	
			<productview/>
		</div>
		<Subscribe/>
		<Footer/>	

	<StickyFooter/>

	<!-- Start of Scroll Top -->
    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="fas fa-chevron-up"></i></a>
    <!-- End of Scroll Top -->
    <MobileMenu/>
</div>

</template>

<script>
	import Header from "./components/layout/Header.vue";
	import Footer from "./components/layout/Footer.vue";
	import StickyFooter from "./components/layout/StickyFooter.vue"
	import MobileMenu from  "./components/layout/MobileMenu.vue";
	import Subscribe from "./components/layout/Subscribe.vue";
	import Login from "./components/auth/login.vue";
	import productview from "./components/layout/product-view.vue";
	export default{
		name: 'App',
		components:{
			Header,
			Footer,
			StickyFooter,
			MobileMenu,
			Subscribe,
			productview,
			Login
		}
	};
</script>