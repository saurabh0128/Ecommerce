

<template>
	<!-- Start of Main -->
        <main class="main cart">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="active"><router-link :to="{name:'cart'}">Shopping Cart</router-link></li>
                        <li><router-link :to="{name:'checkout'}">Checkout</router-link></li>
                        <li><a href="order.html">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <div class="col-lg-8 pr-lg-4 mb-6">

                            <form action="#" @submit.prevent="updateCart" method="post" accept-charset="utf-8">
                                
                            
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th class="product-name"><span>Product</span></th>
                                        <th></th>
                                        <th class="product-price"><span>Price</span></th>
                                        <th class="product-quantity"><span>Quantity</span></th>
                                        <th class="product-subtotal"><span>Subtotal</span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="(product,index) in allProduct" :key="product.id">
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="product-default.html">
                                                    <figure>
                                                        <img :src="'backend_asset/thumbnail/product_images/'+ product.image" alt="product"
                                                            width="300" height="338">
                                                    </figure>
                                                </a>
                                                <button type="button" @click.prevent="removeCart(product.id ,product.product_id ,product.price,product.quantity)"  class="btn btn-close"><i class="fas fa-times"></i></button>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a href="product-default.html">
                                               {{ product.name }}
                                            </a>
                                        </td>
                                        <td class="product-price"><span class="amount">₹{{product.price}}</span></td>
                                        <td class="product-quantity">
                                            <div class="input-group">

                                                <input v-model.number="allProduct[index].quantity" :id="index + 'ProductQty'" @input="productQtyChange(index)" required  class="productQty form-control" type="number" min="1" max="100000">

                                                <button @click.prevent="ProductPlus(index)" class="quantity-plus w-icon-plus"></button>

                                                <button @click.prevent="ProductMinus(index)"  class="quantity-minus w-icon-minus"></button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">₹{{product.subTotal  }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="cart-action mb-6">
                                <router-link :to="{name:'shop'}" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto" ><i class="w-icon-long-arrow-left"></i>Continue Shopping</router-link>
                                <button type="button" @click.prevent="clearCart" class="btn btn-rounded btn-default btn-clear" name="clear_cart"  value="Clear Cart">Clear Cart</button> 
                                <button type="submit"  class="btn btn-rounded btn-update" name="update_cart" value="Update Cart">Update Cart</button>
                            </div>

                            </form>



                            <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input v-model="coupon" id="txtcoupon" type="text" class="form-control mb-4" placeholder="Enter coupon code here..." required />
                                <button @click.prevent="applyCoupon" class="btn btn-dark  btn-outline btn-rounded" 
                                id="ApplyCoupanButton">Apply Coupon</button>
                                <label v-if="totalDiscount" class="product-label label-discount " style="background:#cecccb">{{ getCoupon }} <button type="button" @click.prevent="removeCoupon"  class="btn-close"> </button></label>
                            </form>
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span v-if="this.loggedIn">₹{{subTotal}}  </span>
                                        <span v-else>₹{{ allProductTotal }} </span>
                                    </div>

                                    <hr class="divider">

                                    <!-- <ul class="shipping-methods mb-2">
                                        <li>
                                            <label
                                                class="shipping-title text-dark font-weight-bold">Shipping</label>
                                        </li>

                                    </ul> -->

                                    <!-- <div class="shipping-calculator">
                                        <p class="shipping-destination lh-1">Shipping to <strong>CA</strong>.</p>

                                        <form class="shipping-calculator-form" @submit.prevent="updateCart">
                                            <div class="form-group">
                                                <div class="">
                                                    <select @change="StateWiseCity()"  name="state" v-model="stateId" class="form-control form-control-md">
                                                        <option value="" >Select the State</option>
                                                        <option v-for="singleState in allStates" :key="singleState.id" :value="singleState.id"  >
                                                            {{ singleState.StateName }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">
                                                    <select name="city" class="form-control form-control-md" v-model="cityId" >
                                                        <option value="">Select the City</option>
                                                        <option v-for="singlecitys in allCitys" :value="singlecitys.id" >{{singlecitys.city_name}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-md" type="text" v-model="address"
                                                    name="address" placeholder="Address">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-md" type="number" v-model="pincode"
                                                    name="pincode" placeholder="PINCODE">
                                            </div>
                                            <button type="submit" class="btn btn-dark btn-outline btn-rounded">Update Totals</button>
                                        </form>
                                    </div> -->

                                    <hr class="divider mb-6">
                                   
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Discount</label>
                                        <span class="ls-50">₹{{ totalDiscount }}</span>
                                    </div>
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span v-if="this.loggedIn"  class="ls-50">₹{{ subTotal | finalTotal(parseInt(totalDiscount)) }}</span>
                                        <span v-else class="ls-50">₹{{ allProductTotal }} </span>
                                    </div>
                                    <router-link :to="{name:'checkout'}" class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
            {{ DisplayCart() }}
        </main>
        <!-- End of Main -->
</template>


<script>


import {mapActions, mapGetters} from 'vuex'
export default {
    name:'Cart',
    filters:{
        finalTotal:function(val1,val2)
        {
           return val1 - val2;
        }
    },
    data(){
        return{
            allProduct:null,
            allProductTotal:0,
            coupon:null,
            stateId:"",
            cityId:"",
            address:null,
            pincode:null
        }
    },
    computed:{
        ...mapGetters(['allCart','loggedIn','tPrice','totalDiscount','getCoupon','allStates','allCitys']),
        subTotal:function(){
            let total = 0;
            this.allCart.forEach((a)=> total += Math.floor(a.price * a.quantity ) );
            return total;
        }
    },
    methods:{
        ...mapActions(['getCart','getAllCouponData','updateCartProduct','removeCartProduct','clearCartProduct','addCoupon','rmvCoupan','rmvCoupan','removeCartProductCoupon','updateCoupon','getLocation','selectCity']),
        DisplayCart()
        {
            if(this.allCart.length){
                this.allProduct = this.allCart;
                this.allProductTotal = this.tPrice;
            }   
            else{
                this.allProduct = null;
                this.allProductTotal = 0;
            }
        },
        ProductPlus(index)
        {
            if(this.allProduct[index].quantity < 100000)
            {
                this.allProduct[index].quantity++;   
                this.allProduct[index].subTotal  = this.allProduct[index].price * this.allProduct[index].quantity;
            }
        },
        ProductMinus(index)
        {
            if(this.allProduct[index].quantity > 1)
            {
                this.allProduct[index].quantity--;
                this.allProduct[index].subTotal  = this.allProduct[index].price * this.allProduct[index].quantity;
            }
        },
        productQtyChange(index){
            if(this.allProduct[index].quantity >0 && this.allProduct[index].quantity<=100000)
            {
                this.allProduct[index].subTotal  = this.allProduct[index].price * this.allProduct[index].quantity;
            }
        },
        async updateCart()
        {
            if(this.allProduct){
                if(this.loggedIn){
                    var response = await this.updateCartProduct(this.allProduct);
                    this.getAllCouponData();
                }
                else{
                    var updatedProduct=this.allProduct;
                    var response = await this.updateCartProduct(updatedProduct);
                    this.DisplayCart();
                }
                this.$toastr.s(response);
            }
        },
        async removeCart(id,product_id)
        {   
            this.removeCartProductCoupon(product_id);
            var result = await this.removeCartProduct(id);
            this.getCart();
            this.DisplayCart();
            this.getAllCouponData();
            this.$toastr.s(result); 
        },
        async clearCart()
        {
            var clearCartRes = await this.clearCartProduct();
            this.getCart();
            this.DisplayCart();
            this.rmvCoupan();
            this.$toastr.s(clearCartRes);
        },
        async applyCoupon()
        {
            if(!this.loggedIn)
            {
               $('#ApplyCoupanButton').addClass('sign-in');
            }
            else
            {
                var applyCouponRes = await this.addCoupon(this.coupon);
                $('#txtcoupon').val('');
                this.coupon = null;
                this.$toastr.s(applyCouponRes);
            }
        },
        async removeCoupon(){
            var rmvCouponRes = await this.rmvCoupan();
            this.$toastr.s(rmvCouponRes);
        },
        StateWiseCity(){
            // console.log(this.stateId);
            this.selectCity(this.stateId);
            this.cityId ="";
        }
    },
    mounted() {
        let StickyScript = document.createElement('script')
        StickyScript.setAttribute('src', '/frontend_asset/vendor/sticky/sticky.min.js')
        document.head.appendChild(StickyScript)
    },
    async created(){

        await this.getCart();
        if(this.loggedIn)
        {
            await this.getAllCouponData();
        }
        this.getLocation();
    }
};
</script> 