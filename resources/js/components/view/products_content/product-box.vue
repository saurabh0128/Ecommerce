<template>
    
<div  class="product-wrapper row cols-xl-5 cols-lg-3 cols-md-4 cols-sm-3 cols-2">    
    <div v-for="product in allProduct.data" :key="product.id"  >        
        <div class="product-wrap">
            <div class="product text-center">
                <figure class="product-media">
                    <a href="product-default.html">
                        <img :src="'backend_asset/product_images/' + product.product_img " alt="Product" width="300"height="338" />
                    </a>
                    <div class="product-action-horizontal">
                        <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                            title="Add to cart"></a>
                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                            title="Wishlist"></a>
                        <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                            title="Compare"></a>
                        <a href="#" @click.prevent="setProduct(product)"  class="btn-product-icon btn-quickview w-icon-search"
                            title="Quick View"></a>
                    </div>
                </figure>
                <div class="product-details">
                    <div class="product-cat">
                        <a href="shop-banner-sidebar.html">{{ product.category.category_name }}</a>
                    </div>
                    <h3 class="product-name">
                        <a href="product-default.html">{{ product.product_name }} </a>
                    </h3>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" :style=" 'width:' + avg_per(product.rating)  + '%' "></span>
                            <!-- <span class="tooltiptext tooltip-top"></span> -->
                        </div>
                        <a  class="rating-reviews"> {{ product.rating_review| total_rating  }}</a>
                    </div>
                    <div class="product-pa-wrapper">
                        <div class="product-price">
                          <ins class="new-price">₹{{ product.special_price || product.current_price  }}</ins>
                          <del v-if="product.special_price"  class="old-price">₹{{ product.current_price }} </del>
                        </div>
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
        },
        // addToCart()
        // {
        //         alert('s');
        //         console.log('sk');
        // }
    },
    computed: mapGetters(['allProduct'])
};




</script>       