

<template>
	<!-- Start of Main -->
        <main class="main cart">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="active"><a href="cart.html">Shopping Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
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
                                                <button type="submit" class="btn btn-close"><i
                                                        class="fas fa-times"></i></button>
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

                                                <input v-model.number="allProduct[index].quantity" :id="index + 'ProductQty' "  class="productQty form-control" type="number" min="1" max="100000">

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
                                <a href="#" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                                <button type="button" class="btn btn-rounded btn-default btn-clear" name="clear_cart" value="Clear Cart">Clear Cart</button> 
                                <button type="submit" @click.prevent="updateCart" class="btn btn-rounded btn-update" name="update_cart" value="Update Cart">Update Cart</button>
                            </div>

                            <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input type="text" class="form-control mb-4" placeholder="Enter coupon code here..." required />
                                <button class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            </form>
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span>$100.00</span>
                                    </div>

                                    <hr class="divider">

                                    <ul class="shipping-methods mb-2">
                                        <li>
                                            <label
                                                class="shipping-title text-dark font-weight-bold">Shipping</label>
                                        </li>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="free-shipping" class="custom-control-input"
                                                    name="shipping">
                                                <label for="free-shipping"
                                                    class="custom-control-label color-dark">Free
                                                    Shipping</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="local-pickup" class="custom-control-input"
                                                    name="shipping">
                                                <label for="local-pickup"
                                                    class="custom-control-label color-dark">Local
                                                    Pickup</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="flat-rate" class="custom-control-input"
                                                    name="shipping">
                                                <label for="flat-rate" class="custom-control-label color-dark">Flat
                                                    rate:
                                                    $5.00</label>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="shipping-calculator">
                                        <p class="shipping-destination lh-1">Shipping to <strong>CA</strong>.</p>

                                        <form class="shipping-calculator-form">
                                            <div class="form-group">
                                                <div class="">
                                                    <select name="country" class="form-control form-control-md">
                                                        <option value="default" selected="selected">United States
                                                            (US)
                                                        </option>
                                                        <option value="us">United States</option>
                                                        <option value="uk">United Kingdom</option>
                                                        <option value="fr">France</option>
                                                        <option value="aus">Australia</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">
                                                    <select name="state" class="form-control form-control-md">
                                                        <option value="default" selected="selected">California
                                                        </option>
                                                        <option value="ohaio">Ohaio</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-md" type="text"
                                                    name="town-city" placeholder="Town / City">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control form-control-md" type="text"
                                                    name="zipcode" placeholder="ZIP">
                                            </div>
                                            <button type="submit" class="btn btn-dark btn-outline btn-rounded">Update Totals</button>
                                        </form>
                                    </div>

                                    <hr class="divider mb-6">
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span class="ls-50">$100.00</span>
                                    </div>
                                    <a href="#" class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
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
    data(){
        return{
            allProduct:null
        }
    },
    computed:{
        ...mapGetters(['allCart','loggedIn'])
    },
    methods:{
        ...mapActions(['getCart','updateCartProduct']),
        DisplayCart()
        {
            if(this.$store.getters.allCart.length){
                this.allProduct = this.allCart;
            }
        },
        ProductPlus(index)
        {
            if(this.allProduct[index].quantity < 100000);
            this.allProduct[index].quantity++;   
            $('#'+ index +'ProductQty').val(this.allProduct[index].quantity);
            this.allProduct[index].subTotal  = this.allProduct[index].price * this.allProduct[index].quantity;
            
        },
        ProductMinus(index)
        {
            // console.log('minus');
            if(this.allProduct[index].quantity > 1);
            this.allProduct[index].quantity--;
            $('#'+ index +'ProductQty').val(this.allProduct[index].quantity);
            this.allProduct[index].subTotal  = this.allProduct[index].price * this.allProduct[index].quantity;
        },
        updateCart()
        {
            if(this.loggedIn){
                console.log('Logged In');
            }
            else{
                var updatedProduct=this.allProduct;
                this.updateCartProduct(updatedProduct);
                this.DisplayCart();
            }
        }
    },
    mounted() {
        let StickyScript = document.createElement('script')
        StickyScript.setAttribute('src', '/frontend_asset/vendor/sticky/sticky.min.js')
        document.head.appendChild(StickyScript)

    },
    async created(){
        await this.getCart();
        // console.log(this.$store.getters.allCart);
    }
};
</script> 