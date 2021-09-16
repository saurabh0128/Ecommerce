<template>
<div>        
    <div v-for="product in allProduct.data" :key="product.id"  > 
        <div class="product product-list product-select"> 
            <figure class="product-media">
                <a href="product-default.html">
                    <img  :src="'backend_asset/product_images/' + product.product_img " alt="Product" 
                    width="330" height="338" />
                </a>
                <div class="product-action-vertical">
                    <a @click.prevent="setProduct(product)" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#ProductModel"  class="btn-product-icon btn-quickview w-icon-search" title="Quick View"></a>
                </div>
            </figure>
            <div class="product-details">
                <div class="product-cat">
                    <a href="shop-banner-sidebar.html">{{ product.category.category_name }}</a>
                </div>
                <h4 class="product-name">
                    <a href="product-default.html">{{ product.product_name }}</a>
                </h4>
                <div class="ratings-container">
                    <div class="ratings-full">
                        <span class="ratings" :style=" 'width:' + avg_per(product.rating)  + '%' "></span>
                    </div>
                    <a href="product-default.html" class="rating-reviews">{{ product.rating_review| total_rating  }}</a>
                </div>
                <div class="product-price">₹{{ product.special_price || product.current_price  }}</div>
                <div class="product-desc">
                    Ultrices eros in cursus turpis massa cursus mattis. Volutpat ac tincidunt
                    vitae semper quis lectus. Aliquam id diam maecenas ultricies…
                </div>
                <div class="product-action">
                    <a href="product-default.html" class="btn-product btn-cart"
                        title="Add to Cart"><i class="w-icon-cart"></i>Select Options</a>
                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                        title="Add to wishlist"></a>
                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                        title="Compare"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>


<script>
import { mapGetters,mapActions } from 'vuex';

export default{
    name:'Product_List',
    filters:{
        total_rating:function(value){
            return " (" + value.length+" reviews)";
        }
    },
    methods:{
        ...mapActions(['getSingleProduct']),
        avg_per(value){
            return value * 100 /5 ;
        },
        setProduct(val)
        {
            this.getSingleProduct(val);
            $('.header-bottom').removeClass('fixed');
            $('body').css("overflow-y",'hidden');
        }
    },
    computed: mapGetters(['allProduct'])
};
</script>
