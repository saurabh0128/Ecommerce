
<style scoped >
	@import '/frontend_asset/vendor/nouislider/nouislider.min.css';
</style>
	


<template>
    
	 <!-- Start of Main -->
        <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="demo1.html">Home</a></li>
                        <li><a href="shop-banner-sidebar.html">Shop</a></li>
                        <li>Both Sidebar</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb --> 

            <!-- Start of Page Content -->
            <div class="page-content mb-10">
               <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
                    style="background-image: url(frontend_asset/images/shop/banner2.jpg); background-color: #FFC74E;">
                    <div class="container banner-content">
                        <h4 class="banner-subtitle font-weight-bold">Accessories Collection</h4>
                        <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-10">Smart Watches</h3>
                        <a href="shop-banner-sidebar.html" class="btn btn-dark btn-rounded btn-icon-right">Discover
                            Now<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                </div>
                <!-- End of Shop Banner -->
                <div class="container-fluid">
                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar left-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <div class="filter-actions">
                                        <label>Filter :</label>
                                        <a @click.prevent="clearFilter" href="#" class="btn btn-dark btn-link filter-clean">Clean All</a>
                                    </div>
                                    <!-- Start of Collapsible widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>All Categories</label></h3>
                                        <ul  class="widget-body filter-items search-ul">
                                            <!-- Display All Category and store category id for filter  main category contain sub category product also -->
                                            <li v-for="category in allCategory" :key="category.id"  ><a v-on:click.prevent=" CategoryFilter($event)" :categoryid="category.id" href="#"  >{{ category.category_name }}</a></li>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Price</label></h3>
                                        <div class="widget-body">
                                            <!-- min max filter with fixed price or customise price -->
                                            <ul class="filter-items search-ul">
                                                <li><a href="#" @click.prevent="minMaxFilter(0,100)"  >₹0.00 - ₹100.00</a></li>
                                                <li><a href="#" @click.prevent="minMaxFilter(100,200)" >₹100.00 - ₹200.00</a></li>
                                                <li><a href="#" @click.prevent="minMaxFilter(200,300)" >₹200.00 - ₹300.00</a></li>
                                                <li><a href="#" @click.prevent="minMaxFilter(300,500)" >₹300.00 - ₹500.00</a></li>
                                                <li><a href="#" @click.prevent="minMaxFilter(500)" >₹500.00+</a></li>
                                            </ul>
                                            <form class="price-range">
                                                <input type="number" v-model="filter.min" name="min_price" class="min_price text-center" placeholder="₹min"><span class="delimiter">-</span><input type="number" v-model="filter.max"  name="max_price" class="max_price text-center"
                                                placeholder="₹max">
                                                <button type="submit"  @click.prevent="ProductFilter" class="btn btn-primary btn-rounded">Go</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Seller</label></h3>
                                        <!-- seller filter display all selet name and store seller id for filter -->
                                        <ul class="widget-body filter-items item-check mt-1">
                                            <li v-for="seller in allSeller" :key="seller.id" ><a 
                                                :sellerid="seller.id" v-on:click.prevent="SellerFilter($event)"   href="#">{{ seller.name }}</a></li>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->

                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            <nav class="toolbox sticky-toolbox sticky-content fix-top">
                                <div class="toolbox-left">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle btn-icon-left d-block d-lg-none"><i class="w-icon-category"></i><span>Filters</span></a>
                                    <div class="toolbox-item toolbox-sort select-box text-dark">
                                        <label>Sort By :</label>
                                        <!-- alll sorting and store sorting name -->
                                        <select name="sorting" id="sorting" v-model="filter.sorting"  
                                        class="form-control" @change.prevent="ProductFilter" >
                                            <option value="" selected>Default sorting</option>
                                            <option value="popularity">popularity</option>
                                            <option value="rating">average rating</option>
                                            <option value="date">latest</option>
                                            <option value="ltoh">pric: low to high</option>
                                            <option value="htol">price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="toolbox-right">
                                    <div class="toolbox-item toolbox-show select-box">
                                        <select name="count" v-model="filter.totalproduct" @change.prevent="ProductFilter"  class="form-control">
                                            <option value="2" selected >Show 9</option>
                                            <option value="3" >Show 12</option>
                                            <option value="4">Show 24</option>
                                            <option value="36">Show 36</option>
                                        </select>
                                    </div>
                                    <div class="toolbox-item toolbox-layout">
                                       <a @click.prevent="productTypeBox" class="icon-mode-grid btn-layout " id="product-box"  >
                                            <i class="w-icon-grid"></i>
                                        </a>
                                         <a @click.prevent="productTypeList" class="icon-mode-list btn-layout" id="product-list" >
                                            <i class="w-icon-list"></i>
                                        </a>
                                    </div>
                                </div>
                            </nav>
                         
                                <!-- Box wise All Products -->
                                    <Product_Box v-if="productDisplayType == 'box' " ></Product_Box>
                                <!-- End Box wise All Products  -->

                                <!-- List wise All Products -->
                                    <Product_List v-if="productDisplayType == 'list' " > </Product_List>
                                <!-- List wise All Products -->

                            <div class="toolbox toolbox-pagination justify-content-between">
                                <p class="showing-info mb-2 mb-sm-0">
                                    Showing<span>1-12 of 60</span>Products
                                </p>
                                <ul class="pagination">
                                    <li class="prev disabled">
                                        <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                            <i class="w-icon-long-arrow-left"></i>Prev
                                        </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="next">
                                        <a href="#" aria-label="Next">
                                            Next<i class="w-icon-long-arrow-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->

                       
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->


</template>



<script>

import Product_Box from "./products_content/product-box.vue";

import Product_List from "./products_content/product-list.vue";
import { mapGetters,mapActions } from 'vuex';


export default {
name: 'Shop',
// product box for box view of product or product list for list view of product
components:{
    Product_Box,
    Product_List
},
// all data relater to a filter or sorting
data(){
    return{
        productDisplayType:localStorage.getItem('productDisplayType') || 'box',
        filter:{
            sorting:'',
            min:'',
            max:'',
            category:'',
            seller:[],
            totalproduct:10
        }
    }
},
//automaticaly call when data chage in given name like allproduct,allcategory etc it is connected with store
computed:{
    ...mapGetters(['allProduct','allCategory','allSeller']),
},

methods:{
    //all get method for get all data
     ...mapActions(['getProducts']),
     ...mapActions(['getSeller']),
     ...mapActions(['getCategory']),
    //method for a box type view of product 
    productTypeBox(){
        // this.productDisplayType = 'box'
        localStorage.setItem('productDisplayType','box')
        $('#product-box').addClass('active');
        $('#product-list').removeClass('active');
    },
    //method for a list type of view
    productTypeList(){
        // this.productDisplayType = 'list'
        localStorage.setItem('productDisplayType','list')
        $('#product-list').addClass('active');
        $('#product-box').removeClass('active');
    },
    //method for a minmax filter 
    minMaxFilter(min,max = 0 ){
      this.filter.min = min;
      this.filter.max = max|0;
      this.ProductFilter()
    },
    //method for a category filter
    CategoryFilter(event)
    {
       //get data of clicked tag using event   
       var category = event.currentTarget.getAttribute('categoryid');
       this.filter.category = category;
       this.ProductFilter();
    },
    //method for seller filter
    SellerFilter(event)
    {
        var sellers = this.filter.seller;
        var newSeller = event.currentTarget.getAttribute('sellerid');
        if(sellers.includes(newSeller)){
            var oldSellerIndex = sellers.indexOf(newSeller);
            sellers.splice(oldSellerIndex,1);
        }
        else{
            sellers.push(newSeller);
        }
        this.filter.seller = sellers;
        this.ProductFilter();
    },
    //clean all filter
    clearFilter(){
        this.filter.sorting = '',
        this.filter.min = '',
        this.filter.max = '',
        this.filter.category = '',
        this.filter.seller = []
        this.ProductFilter();
    },
    //to get all product after apply filter
    ProductFilter(){
       this.getProducts(this.filter);
    }
},
//page load time call method
async created(){
    await this.getCategory(1),
    await this.getSeller()
},
//call js when page load and set product view type if not previous select it will boc view other wise as per selected
mounted() {
    let StickyScript = document.createElement('script')
    StickyScript.setAttribute('src', '/frontend_asset/vendor/sticky/sticky.min.js')
    document.head.appendChild(StickyScript)

    let NouisliderScript = document.createElement('script')
    NouisliderScript.setAttribute('src', '/frontend_asset/vendor/nouislider/nouislider.min.js')
    document.head.appendChild(NouisliderScript)

    if(localStorage.getItem('productDisplayType') && localStorage.getItem('productDisplayType') =='list')
    {
        $('#product-list').addClass('active');
    }
    else
    {
        $('#product-box').addClass('active');   
    }   
}};

</script>




