<template>
	<!-- Start of Main -->
        <main class="main checkout">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="passed"><router-link :to="{name:'cart'}">Shopping Cart</router-link></li>
                        <li class="active"><router-link :to="{name:'checkout'}">Checkout</router-link></li>
                        <li><a href="order.html">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->


            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="">
                        Returning customer? <a href="#sign-in"
                            class="show-login sign-in font-weight-bold text-uppercase text-dark" >Login</a>
                    </div>
                    
                    <div class="coupon-toggle">
                        Have a coupon? <a href="#"
                            class="show-coupon font-weight-bold text-uppercase text-dark">Enter your
                            code</a>
                    </div>
                    <div class="coupon-content mb-4">
                        <p>If you have a coupon code, please apply it below.</p>
                        <div class="input-wrapper-inline">
                            <input type="text" name="coupon_code" v-model="coupon" class="form-control form-control-md mr-1 mb-2" placeholder="Coupon code" id="coupon_code">
                            <button type="button" @click="applyCoupon" class="btn button btn-rounded btn-coupon mb-2" name="apply_coupon" value="Apply coupon">Apply Coupon</button>
                        </div>
                    </div>
                    <form class="form checkout-form" action="#" method="post">
                        <div class="row mb-9">
                            <div class="col-lg-7 pr-lg-4 mb-4">
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Billing Details
                                </h3>
                                <div class="row gutter-sm">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>First name *</label>
                                            <input type="text" v-model="BillingAddress.FirstName" class="form-control form-control-md" name="firstname"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Last name *</label>
                                            <input type="text" v-model="BillingAddress.LastName" class="form-control form-control-md" name="lastname"
                                                required>
                                        </div>
                                    </div>
                                </div>
                              	<div class="form-group mb-7">
                                    <label>Email address *</label>
                                    <input type="email" class="form-control form-control-md"  v-model="BillingAddress.Email" name="email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Street address *</label>
                                    <input type="text" placeholder="House number and street name"
                                        class="form-control form-control-md mb-2" v-model="BillingAddress.Address_1" name="street-address-1" required>
                                    <input type="text" placeholder="Apartment, suite, unit, etc. (optional)"
                                        class="form-control form-control-md" v-model="BillingAddress.Address_2" name="street-address-2" required>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Town / City *</label>
                                                <select name="city" v-model="BillingAddress.city" class="form-control form-control-md">
                                                    <option value="" >Select the City</option>
                                                    <option :value="city.id" v-for="city in allCitys " >{{ city.city_name }}</option>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label>PINCODE *</label>
                                            <input type="number" class="form-control form-control-md" v-model="BillingAddress.pincode"  name="pincode" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State *</label>
                                                <select name="state" @change="StateWiseCity()" v-model="BillingAddress.state" class="form-control form-control-md">
                                                    <option value="" >Select the State</option>
                                                    <option :value="state.id" v-for="state in allStates " >{{ state.StateName }}</option>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone *</label>
                                            <input type="number" v-model="BillingAddress.phone" class="form-control form-control-md" name="phone" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group checkbox-toggle pb-2">
                                    <input type="checkbox" class="custom-checkbox" id="shipping-toggle"
                                        name="shipping-toggle">
                                    <label for="shipping-toggle">Ship to a different address?</label>
                                </div>
                                <div class="checkbox-content">
                                    <div class="row gutter-sm">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>First name *</label>
                                                <input type="text" v-model="ShippingAddress.FirstName" class="form-control form-control-md" name="firstname"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Last name *</label>
                                                <input type="text" v-model="ShippingAddress.LastName" class="form-control form-control-md" name="lastname"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label>Street address *</label>
                                        <input type="text" v-model="ShippingAddress.address_1" placeholder="House number and street name" class="form-control form-control-md mb-2" name="street-address-1" required>
                                        <input type="text" v-model="ShippingAddress.address_2" placeholder="Apartment, suite, unit, etc. (optional)" class="form-control form-control-md" name="street-address-2" required>
                                    </div>
                                    <div class="row gutter-sm">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Town / City *</label>
                                                <select name="city" v-model="ShippingAddress.city" class="form-control form-control-md">
                                                    <option value="" >Select the City</option>
                                                    <option :value="city.id" v-for="city in allCitys " >{{ city.city_name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Pincode *</label>
                                                <input type="number" v-model="ShippingAddress.pincode" class="form-control form-control-md" name="postcode" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State *</label>
                                                <select name="state" @change="StateWiseCity2()" v-model="ShippingAddress.state" class="form-control form-control-md">
                                                    <option value="" >Select the State</option>
                                                    <option :value="state.id" v-for="state in allStates " >{{ state.StateName }}</option>
                                                </select>    
                                            </div>
                                            <div class="form-group">
                                                <label>Phone *</label>
                                                <input type="number" v-model="ShippingAddress.phone" class="form-control form-control-md" name="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="order-notes">Order notes (optional)</label>
                                    <textarea  v-model="OrederNotes" class="form-control mb-0" id="order-notes"  name="order-notes" cols="30"
                                        rows="4" placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                                <div class="order-summary-wrapper sticky-sidebar">
                                    <h3 class="title text-uppercase ls-10">Your Order</h3>
                                    <div class="order-summary">
                                        <table class="order-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <b>Product</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="cart_item in allCart" class="bb-no">
                                                    <td class="product-name">{{ cart_item.name}} <i class="fas fa-times"></i>
                                                        <span class="product-quantity">{{ cart_item.quantity }}</span></td>
                                                    <td class="product-total">₹{{ cart_item.subTotal }}</td>
                                                </tr>
                                                <tr class="cart-subtotal bb-no">
                                                    <td>
                                                        <b>Subtotal</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ subTotal}}</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="shipping-methods">
                                                    <td colspan="2" class="text-left">
                                                        <h4 class="title title-simple bb-no mb-1 pb-0 pt-3">Shipping
                                                        </h4>
                                                        <ul id="shipping-method" class="mb-4">
                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="free-shipping"
                                                                        class="custom-control-input" name="shipping">
                                                                    <label for="free-shipping"
                                                                        class="custom-control-label color-dark">Free
                                                                        Shipping</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="local-pickup"
                                                                        class="custom-control-input" name="shipping">
                                                                    <label for="local-pickup"
                                                                        class="custom-control-label color-dark">Local
                                                                        Pickup</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="flat-rate"
                                                                        class="custom-control-input" name="shipping">
                                                                    <label for="flat-rate"
                                                                        class="custom-control-label color-dark">Flat
                                                                        rate: $5.00</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>
                                                        <b>Total</b>
                                                    </th>
                                                    <td>
                                                        <b>$100.00</b>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="payment-methods" id="payment_method">
                                            <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                            <div class="accordion payment-accordion">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" class="collapse">Direct Bank Transfor</a>
                                                    </div>  
                                                    <div id="cash-on-delivery" class="card-body expanded">
                                                        <p class="mb-0">
                                                            Make your payment directly into our bank account. 
                                                            Please use your Order ID as the payment reference. 
                                                            Your order will not be shipped until the funds have cleared in our account.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#payment" class="expand">Check Payments</a>
                                                    </div>
                                                    <div id="payment" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#delivery" class="expand">Cash on delivery</a>
                                                    </div>
                                                    <div id="delivery" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Pay with cash upon delivery.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card p-relative">
                                                    <div class="card-header">
                                                        <a href="#paypal" class="expand">Paypal</a>
                                                    </div>
                                                    <a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" class="text-primary paypal-que" 
                                                        onclick="javascript:window.open('https://www.paypal.com/us/webapps/mpp/paypal-popup','WIPaypal',
                                                        'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); 
                                                        return false;">What is PayPal?
                                                    </a>
                                                    <div id="paypal" class="card-body collapsed">
                                                        <p class="mb-0">
                                                            Pay via PayPal, you can pay with your credit cart if you
                                                            don't have a PayPal account.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group place-order pt-6">
                                            <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

	export default{
		name:'checkout',
		data(){
			return{
				BillingAddress:{
					FirstName:'',
					LastName:'',
					Email:'',
                    Address_1:'',
                    Address_2:'',
                    city:'',
                    state:'',
                    pincode:'',
                    phone:''
				},
                ShippingAddress:{
                    FirstName:'',
                    LastName:'',
                    Address_1:'',
                    Address_2:'',
                    city:'',
                    state:'',
                    pincode:'',
                    phone:''
                },
                OrederNotes:'',
                coupon:''	
			}
		},
        computed:{
            ...mapGetters(['allCart','allStates','allCitys','loggedIn']),
            subTotal:function(){
            let total = 0;
            this.allCart.forEach((a)=> total += Math.floor(a.price * a.quantity ) );
            return total;
        }
        },
        methods:{
            ...mapActions(['getLocation','selectCity','addCoupon']),
            StateWiseCity(){
                this.selectCity(this.BillingAddress.state);
                this.BillingAddress.city ="";
            },
            StateWiseCity2()
            {
                this.selectCity(this.ShippingAddress.state);
                this.ShippingAddress.city ="";
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
        },
        mounted(){
            if(!this.loggedIn)
            {
                $('#authModal').modal('show');
            }    
        },
        async created(){
            this.getLocation();
        }
	};
</script>			