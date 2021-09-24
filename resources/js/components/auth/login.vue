<template> 

<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
            <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                <ul class="nav nav-tabs text-uppercase" role="tablist">
                    <li class="nav-item">
                        <a href="#sign-in" class="nav-link active">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a href="#sign-up" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="#seller-sign-up" class="nav-link">Seller Sign Up</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="sign-in" >
                        <form method="post" accept-charset="utf-8">
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" v-model="LoginForm.username" class="form-control" name="username" id="username"  required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Password *</label>
                                <input type="password" v-model="LoginForm.password" name="password" id="password"  class="form-control"   required>
                            </div>
                            <div class="form-checkbox d-flex align-items-center justify-content-between">
                                <input type="checkbox" class="custom-checkbox" required="">
                                <label for="remember">Remember me</label>
                                <a href="#">Last your password?</a>
                            </div>
                            <button @click.prevent="login" type="submit" class="btn btn-primary btn-block " >Sign In</button>
                        </form>
                    </div>
                    <div class="tab-pane " id="sign-up">
                        <form method="post" accept-charset="utf-8">
                            <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="RegForm.name"  class="form-control" name="reg_name" id="reg_name" required>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="RegForm.email"  class="form-control" name="reg_email" id="reg_email" required>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="RegForm.username"  type="text" class="form-control" name="reg_username" id="reg_username" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="RegForm.phone_number" type="number" class="form-control" name="reg_phoneumber" id="reg_phoneumber" required>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="RegForm.password" type="password" class="form-control" name="reg_password" id="reg_password" required>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="RegForm.confirm_password" type="password" class="form-control" name="reg_confirm_password" id="reg_confirm_password" required>
                            </div>
                           
                            <a href="#"   class="d-block mb-5 text-primary seller_register  ">Signup as a vendor?</a>
                            <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                <input type="checkbox" v-model="RegForm.agree" class="custom-checkbox" id="user_agree" name="user_agree" required>
                                <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                            </div>
                    
                            <button @click.prevent="register" type="submit" class="btn btn-primary btn-block" >Sign Up</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="seller-sign-up">
                        <form method="post" accept-charset="utf-8">
                           <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="SellerRegForm.name"  class="form-control" name="sel_reg_name" id="sel_reg_name" required>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="SellerRegForm.email"  class="form-control" name="sel_reg_email" id="sel_reg_email" required>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="SellerRegForm.username"  type="text" class="form-control" name="sel_reg_username" id="sel_reg_username" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="SellerRegForm.phone_number" type="number" class="form-control" name="sel_reg_phoneumber" id="sel_reg_phoneumber" required>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="SellerRegForm.password" type="password" class="form-control" name="sel_reg_password" id="sel_reg_password" required>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="SellerRegForm.confirm_password" type="password" class="form-control" name="sel_reg_confirm_password" id="sel_reg_confirm_password" required>
                            </div>
                            
                            
                            <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                <input type="checkbox" v-model="SellerRegForm.agree"  class="custom-checkbox" id="seller_agree" name="seller_agree" required>
                                <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                            </div>
                    
                            <button @click.prevent="sellerregister" type="submit"  class="btn btn-primary btn-block" >Sign Up</button>
                        </form>
                    </div>
                </div>
                <p class="text-center">Sign in with social account</p>
                <div class="social-icons social-icon-border-color d-flex justify-content-center">
                    <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                    <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                    <a href="#" class="social-icon social-google fab fa-google"></a>
                </div>
            </div>
            <button title="Close (Esc)" id="close-login" data-dismiss="modal" aria-label="Close"  type="button" class="mfp-close">
                <span>x</span>
            </button>
      </div>
    </div>
  </div>
</div>


<!-- 
 <div class="login-modal-bg"> 
        <div class=" login-popup login-box ">
            <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                <ul class="nav nav-tabs text-uppercase" role="tablist">
                    <li class="nav-item">
                        <a href="#sign-in" class="nav-link active">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a href="#sign-up" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="#seller-sign-up" class="nav-link">Seller Sign Up</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="sign-in" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <form method="post" accept-charset="utf-8">
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" v-model="LoginForm.username" class="form-control" name="username" id="username"  required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Password *</label>
                                <input type="password" v-model="LoginForm.password" name="password" id="password"  class="form-control"   required>
                            </div>
                            <div class="form-checkbox d-flex align-items-center justify-content-between">
                                <input type="checkbox" class="custom-checkbox" required="">
                                <label for="remember">Remember me</label>
                                <a href="#">Last your password?</a>
                            </div>
                            <button @click.prevent="login" type="submit" class="btn btn-primary btn-block " >Sign In</button>
                        </form>
                    </div>
                    <div class="tab-pane " id="sign-up">
                        <form method="post" accept-charset="utf-8">
                            <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="RegForm.name"  class="form-control" name="reg_name" id="reg_name" required>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="RegForm.email"  class="form-control" name="reg_email" id="reg_email" required>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="RegForm.username"  type="text" class="form-control" name="reg_username" id="reg_username" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="RegForm.phone_number" type="number" class="form-control" name="reg_phoneumber" id="reg_phoneumber" required>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="RegForm.password" type="password" class="form-control" name="reg_password" id="reg_password" required>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="RegForm.confirm_password" type="password" class="form-control" name="reg_confirm_password" id="reg_confirm_password" required>
                            </div>
                           
                            <a href="#"   class="d-block mb-5 text-primary seller_register  ">Signup as a vendor?</a>
                            <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                <input type="checkbox" v-model="RegForm.agree" class="custom-checkbox" id="user_agree" name="user_agree" required>
                                <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                            </div>
                    
                            <button @click.prevent="register" type="submit" class="btn btn-primary btn-block" >Sign Up</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="seller-sign-up">
                        <form method="post" accept-charset="utf-8">
                           <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="SellerRegForm.name"  class="form-control" name="sel_reg_name" id="sel_reg_name" required>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="SellerRegForm.email"  class="form-control" name="sel_reg_email" id="sel_reg_email" required>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="SellerRegForm.username"  type="text" class="form-control" name="sel_reg_username" id="sel_reg_username" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="SellerRegForm.phone_number" type="number" class="form-control" name="sel_reg_phoneumber" id="sel_reg_phoneumber" required>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="SellerRegForm.password" type="password" class="form-control" name="sel_reg_password" id="sel_reg_password" required>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="SellerRegForm.confirm_password" type="password" class="form-control" name="sel_reg_confirm_password" id="sel_reg_confirm_password" required>
                            </div>
                            
                            
                            <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                <input type="checkbox" v-model="SellerRegForm.agree"  class="custom-checkbox" id="seller_agree" name="seller_agree" required>
                                <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                            </div>
                    
                            <button @click.prevent="sellerregister" type="submit" class="btn btn-primary btn-block" >Sign Up</button>
                        </form>
                    </div>
                </div>
                <p class="text-center">Sign in with social account</p>
                <div class="social-icons social-icon-border-color d-flex justify-content-center">
                    <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                    <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                    <a href="#" class="social-icon social-google fab fa-google"></a>
                </div>
            </div>
            <button title="Close (Esc)" id="close-login"  type="button" class="mfp-close">
                <span>x</span>
            </button>
        </div>
</div>	 -->
</template>	

<script>
import {mapActions,mapGetters} from 'vuex';
    
    function formclear() {
        $('#username').val('');
        $('#password').val(''); 
        $('#mainerror').html('');
        $('#usernameerror').html('');
        $('#passworderror').html('');
    }

    function  RegFormClear() {
        $('#reg_name').val('');
        $('#reg_email').val('');
        $('#reg_username').val('');
        $('#reg_phoneumber').val('');
        $('#reg_password').val('');
        $('#reg_confirm_password').val('');
        $('#user_agree').prop('checked', false);

    }

    function  SelRegFormClear() {
        $('#sel_reg_name').val('');
        $('#sel_reg_email').val('');
        $('#sel_reg_username').val('');
        $('#sel_reg_phoneumber').val('');
        $('#sel_reg_password').val('');
        $('#sel_reg_confirm_password').val('');
        $('#seller_agree').prop('checked', false);
    }
    


    export default{
        name:'login',
         //whever error occur in login it will fatch from store 
        computed:{
          ...mapGetters({
                errors:'allErrors',
                loggedIn:'loggedIn'
            })  
        }, 
        //it will check if error in computer id error found it will display
        watch: {
          errors:function(val){
            if(val)
            {
                let errstr = ''
                val.forEach((err)=> errstr += err + "<br/>" );
                this.$toastr.e(errstr)
            }
          }
        },
        //all form data comes into the form variables
        data(){
            return{
                LoginForm:{
                    username:'',
                    password:''
                },
                RegForm:{
                    name:'',
                    email:'',
                    username:'',
                    phone_number:'',
                    password:'',
                    confirm_password:'',
                    user_status:'customer',
                    agree:''
                },  
                SellerRegForm:{
                    name:'',
                    email:'',
                    username:'',
                    phone_number:'',
                    password:'',
                    confirm_password:'',
                    user_status:'seller',
                    agree:''
                },
            }
        },
       
        methods:{
            //import all method from store
            ...mapActions(["userLogin","userRegister","sellerRegister","getCart"]),
            //user login methos with success message
            login(){ 
               this.userLogin(this.LoginForm).then((res)=>{
                   if(this.loggedIn)
                   {
                        this.getCart();
                        $('#authModal').modal('hide');
                        this.$toastr.s('Login Successfully')
                        formclear()
                   }
                })
            },
            async register(){
                let response = await this.userRegister(this.RegForm);
                if(response.status)
                {
                    $('#authModal').modal('hide');
                    this.$toastr.s('Register Successfully')
                    RegFormClear()
                }
            },
            async sellerregister()
            {
               let selresponse = await this.sellerRegister(this.SellerRegForm);
                if(selresponse.status)
                {
                    $('#authModal').modal('hide');
                    this.$toastr.s('Register Successfully')
                    SelRegFormClear()
                }
            }
        }
    }
    
    function login_model() {
        $('#authModal').modal('show');
    }


    $(document).on("click", ".sign-in", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#sign-in"]').click();
    });

    $(document).on("click", ".register", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#sign-up"]').click();
    });

    $(document).on("click", ".seller_register", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#seller-sign-up"]').click();
    });



    $(document).on("click",'#close-login',function(){
        $('#authModal').modal('hide');
        formclear();
        RegFormClear();
        SelRegFormClear();
    });
</script>
