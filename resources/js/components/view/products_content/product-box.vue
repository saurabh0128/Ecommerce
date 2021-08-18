<template>
    
<div>        
    <div v-for="product in allProduct" class="product-wrap">
        <div class="product text-center">
            <figure class="product-media">
                <a href="product-default.html">
                    <img src="frontend_asset/images/shop/1.jpg" alt="Product" width="300"
                        height="338" />
                </a>
                <div class="product-action-horizontal">
                    <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                        title="Add to cart"></a>
                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                        title="Wishlist"></a>
                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                        title="Compare"></a>
                    <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                        title="Quick View"></a>
                </div>
            </figure>
            <div class="product-details">
                <div class="product-cat">
                    <a href="shop-banner-sidebar.html">Electronics</a>
                </div>
                <h3 class="product-name">
                    <a href="product-default.html">3D Television</a>
                </h3>
                <div class="ratings-container">
                    <div class="ratings-full">
                        <span class="ratings" style="width: 100%;"></span>
                        <span class="tooltiptext tooltip-top"></span>
                    </div>
                    <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                </div>
                <div class="product-pa-wrapper">
                    <div class="product-price">
                        $220.00 - $230.00
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { mapGetters,mapActions } from 'vuex';

export default{
    name:'Product_Box',
    methods:{
        ...mapActions(['getProducts'])
    },
    computed: mapGetters(['allProduct']),
    created()
    {
        this.getProducts();
        console.log(this.allProduct)
    }
};
</script>       