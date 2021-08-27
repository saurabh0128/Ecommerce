<template>
	
<!-- Start of Quick View -->
<div  class="product product-single product-popup " id="ProductModel" aria-hidden="true" role="dialog" tabindex="-1" >
    <div v-if="singleProduct" class="row gutter-lg">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="product-gallery product-gallery-sticky mb-0">
                <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                    <figure class="product-image">
                        <img :src="'backend_asset/product_images/'+ singleProduct.product_img"
                            :data-zoom-image="'backend_asset/product_images/'+ singleProduct.product_img"
                            alt="Water Boil Black Utensil" width="800" height="900">
                    </figure>
                </div>
                <div class="product-thumbs-wrap">
                    <div class="product-thumbs">
                        <div class="product-thumb">
                            <img :src="'backend_asset/thumbnail/product_images/'+ singleProduct.product_img " alt="Product Thumb" width="103" height="116">
                        </div>
                    </div>
                    <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                    <button class="thumb-down disabled"><i class="w-icon-angle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-6 overflow-hidden p-relative">
            <div class="product-details scrollable pl-0">
                <h2 class="product-title">{{ singleProduct.product_name }}</h2>
                <div class="product-bm-wrapper">
                    <figure class="brand">
                        <img src="/frontend_asset/images/products/brand/brand-1.jpg" alt="Brand" width="102" height="48" />
                    </figure>
                    <div class="product-meta">
                        <div class="product-categories">
                            Category:
                            <span class="product-category"><a href="#">{{ singleProduct.category.category_name }}</a></span>
                        </div>
                        <div class="product-sku">
                            SKU: <span>MS46891340</span>
                        </div>
                    </div>
                </div>

                <hr class="product-divider">

                <div class="product-price">₹{{ singleProduct.special_price || singleProduct.current_price  }}</div>

                <div class="ratings-container">
                    <div class="ratings-full">
                        <span class="ratings" :style=" 'width:' + avg_per(singleProduct.rating)  + '%' "></span>
                    </div>
                    <a href="#" class="rating-reviews">{{ singleProduct.rating_review| total_rating  }}</a>
                </div>

                <div class="product-short-desc">
                    <ul class="list-type-check list-style-none">
                        <li>Ultrices eros in cursus turpis massa cursus mattis. {{ _cancel() }} </li>
                        <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                        <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                    </ul>
                </div>

                <hr class="product-divider">

   
          

                <div class="product-form">
                    <div class="product-qty-form">
                        <div class="input-group">
                            <input class="quantity form-control" type="number" min="1" max="10000000">
                            <button class="quantity-plus w-icon-plus"    ></button>
                            <button class="quantity-minus w-icon-minus"></button>
                        </div>
                    </div>
                    <a @click="_cancel"  ref="cartbtn" class="btn btn-primary btn-cart">
                        <i class="w-icon-cart"></i>
                        <span>Add to Cart</span>
                    </a>
                </div>

                <div class="social-links-wrapper">
                    <div class="social-links">
                        <div class="social-icons social-no-color border-thin">
                            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                            <a href="#" class="social-icon social-instagram w-icon-instagram"></a>
                            <a href="#" class="social-icon social-youtube w-icon-youtube"></a>
                            <a href="#" class="social-icon social-pinterest w-icon-pinterest"></a>
                        </div>
                    </div>
                    <span class="divider d-xs-show"></span>
                    <div class="product-link-wrapper d-flex">
                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                        <a href="#"
                            class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Quick view -->

</template>


<script>
import { mapGetters,mapActions } from 'vuex';

	export default{
		name:'product_view',
		filters:{
	        total_rating:function(value){
	            return " (" + value.length+" reviews)";
	        }
    	},
    	methods:{
    		avg_per(value){
            	return value * 100 /5 ;
        	},
        	_cancel()
        	{
        		alert('s');
        		console.log('sk');
        	}
    	},
		computed:{
			 ...mapGetters(['singleProduct']),
		},
		mounted(){
			this.$refs.cartbtn.click()
		}
	};
</script>			