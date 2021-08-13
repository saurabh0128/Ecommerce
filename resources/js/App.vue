<template>  

<div>	
		<Header/>
		<router-view></router-view>
		<Footer/>	

	<StickyFooter/>

	<!-- Start of Scroll Top -->
    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="fas fa-chevron-up"></i></a>
    <!-- End of Scroll Top -->
    <MobileMenu/>
</div>

</template>

<script>
	import Header from "./components/layout/header.vue";
	import Footer from "./components/layout/footer.vue";
	import StickyFooter from "./components/layout/StickyFooter.vue"
	import MobileMenu from  "./components/layout/MobileMenu.vue";

	export default{
		name: 'App',
		components:{
			Header,
			Footer,
			StickyFooter,
			MobileMenu
		}
	};
</script>