<template> 
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
                    <div class="tab-pane active" id="sign-in">
                        <form method="post" accept-charset="utf-8">
                            <span v-if="loginerrors[0]" id="mainerror" class="txt-red" >{{ loginerrors[0] }}</span>
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" v-model="LoginForm.username" class="form-control" name="username" id="username"  required>
                                <span v-if="loginerrors.username" id="usernameerror"  class="txt-red" >{{ loginerrors.username[0] }}</span>
                            </div>
                            <div class="form-group mb-0">
                                <label>Password *</label>
                                <input type="password" v-model="LoginForm.password" name="password" id="password"  class="form-control"   required>
                                <span v-if="loginerrors.password" id="passworderror" class="txt-red" >{{ loginerrors.password[0] }}</span>
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
                            <span v-if="regerrors.agree" id="RegAgree"  class="txt-red d-block" >Accept the terms and condition</span>
                            <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="RegForm.name"  class="form-control" name="reg_name" id="reg_name" required>
                                <span v-if="regerrors.name" id="NameError"  class="txt-red" >{{ regerrors.name[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="RegForm.email"  class="form-control" name="reg_email" id="reg_email" required>
                                <span v-if="regerrors.email" id="RegEmailError"  class="txt-red" >{{ regerrors.email[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="RegForm.username"  type="text" class="form-control" name="reg_username" id="reg_username" required>
                                <span v-if="regerrors.username" id="RegUsernameError"  class="txt-red" >{{ regerrors.username[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="RegForm.phone_number" type="number" class="form-control" name="reg_phoneumber" id="reg_phoneumber" required>
                                <span v-if="regerrors.phone_number" id="RegPhoneError"  class="txt-red" >{{ regerrors.phone_number[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="RegForm.password" type="password" class="form-control" name="reg_password" id="reg_password" required>
                                <span v-if="regerrors.password" id="RegPasswordError"  class="txt-red" >{{ regerrors.password[0] }}</span>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="RegForm.confirm_password" type="password" class="form-control" name="reg_confirm_password" id="reg_confirm_password" required>
                                <span v-if="regerrors.confirm_password" id="RegConfirmPasswordError"  class="txt-red" >{{ regerrors.confirm_password[0] }}</span>
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
                            <span v-if="selregerrors.agree" id="SelRegAgree"  class="txt-red d-block" >Accept the terms and condition</span>
                           <div class="form-group" >
                                <label>Your Name*</label>
                                <input type="text" v-model="SellerRegForm.name"  class="form-control" name="sel_reg_name" id="sel_reg_name" required>
                                <span v-if="selregerrors.name" id="SelNameError"  class="txt-red" >{{ selregerrors.name[0] }}</span>
                            </div>

                            <div class="form-group">
                                <label>Your Email Address *</label>
                                <input type="email" v-model="SellerRegForm.email"  class="form-control" name="sel_reg_email" id="sel_reg_email" required>
                                <span v-if="selregerrors.email" id="SelRegEmailError"  class="txt-red" >{{ selregerrors.email[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input  v-model="SellerRegForm.username"  type="text" class="form-control" name="sel_reg_username" id="sel_reg_username" required>
                                <span v-if="selregerrors.username" id="SelRegUsernameError"  class="txt-red" >{{ selregerrors.username[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input v-model="SellerRegForm.phone_number" type="number" class="form-control" name="sel_reg_phoneumber" id="sel_reg_phoneumber" required>
                                <span v-if="selregerrors.phone_number" id="SelRegPhoneError"  class="txt-red" >{{ selregerrors.phone_number[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input v-model="SellerRegForm.password" type="password" class="form-control" name="sel_reg_password" id="sel_reg_password" required>
                                <span v-if="selregerrors.password" id="SelRegPasswordError"  class="txt-red" >{{ selregerrors.password[0] }}</span>
                            </div>
                            <div class="form-group mb-5">
                                <label>Confirm Password *</label>
                                <input v-model="SellerRegForm.confirm_password" type="password" class="form-control" name="sel_reg_confirm_password" id="sel_reg_confirm_password" required>
                                <span v-if="selregerrors.confirm_password" id="SelRegConfirmPasswordError"  class="txt-red" >{{ selregerrors.confirm_password[0] }}</span>
                            </div>
                            
                            
                            <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                <input type="checkbox"v-model="SellerRegForm.agree"  class="custom-checkbox" id="seller_agree" name="seller_agree" required>
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
</div>	
</template>	

<script>
    
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
        $('#user_agree').val('');

        $('#NameError').html('');
        $('#RegEmailError').html('');
        $('#RegUsernameError').html('');
        $('#RegPhoneError').html('');
        $('#RegPasswordError').html('');
        $('#RegConfirmPasswordError').html('');
        $('#RegAgree').html('');


    }

    function  SelRegFormClear() {
        $('#reg_name').val('');
        $('#reg_email').val('');
        $('#reg_username').val('');
        $('#reg_phoneumber').val('');
        $('#reg_password').val('');
        $('#reg_confirm_password').val('');
        $('#seller_agree').val('');

        $('#SelNameError').html('');
        $('#SelRegEmailError').html('');
        $('#SelRegUsernameError').html('');
        $('#SelRegPhoneError').html('');
        $('#SelRegPasswordError').html('');
        $('#SelRegConfirmPasswordError').html('');
        $('#SelRegAgree').html('');


    }
    


    export default{
        data(){
            return{
                LoginForm:{
                    username:'ssk007',
                    password:'saurabh123'
                },
                loginerrors:[],
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
                regerrors:[],
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
                selregerrors:[]
            }
        },
        methods:{
            login(){

                this.loginerrors = []; 
                axios.post('/api/v1/login',this.LoginForm).then((res)=>{
                    if(res.data.status)
                    {
                        $('.login-box').hide();
                        $('.login-modal-bg').hide();
                        $('body').css("overflow-y",'auto');
                        formclear();
                        toastr["success"]('Login Successfully');                  
                        this.$store.dispatch('login',res.data)
                    }   
                    else 
                    {
                        this.loginerrors = res.data.error;
                    }
                    
                })
            },
            register(){
                this.regerrors = [];
                axios.post('/api/v1/registration',this.RegForm).then((res)=>{
                    if(res.data.status)
                    {
                        $('.login-box').hide();
                        $('.login-modal-bg').hide();
                        $('body').css("overflow-y",'auto');
                        RegFormClear();
                        toastr["success"](res.data.message);
                    }
                    else{
                        this.regerrors = res.data.error;
                    }     
                })
            },
            sellerregister()
            {
                this.selregerrors = [];
                axios.post('/api/v1/registration',this.SellerRegForm).then((res)=>{
                    if(res.data.status)
                    {
                        $('.login-box').hide();
                        $('.login-modal-bg').hide();
                        $('body').css("overflow-y",'auto');
                        SelRegFormClear();
                        toastr["success"](res.data.message);
                    }
                    else{
                        this.selregerrors = res.data.error;
                    }     
                })
            }
        }
    }
    
    function login_model() {
        $('.login-modal-bg').show();
        $('.login-box').show();
        $('body').css("overflow-y",'hidden');
    }

    $(document).ready(function(){
        $('.login-box').hide();
        $('.login-modal-bg').hide();
    });

    $(document).on("click", ".sign-in", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#sign-in"]').click()
    });

    $(document).on("click", ".register", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#sign-up"]').click()
    });

    $(document).on("click", ".seller_register", function (e) {
        e.preventDefault();
        login_model();
        $('[href="#seller-sign-up"]').click()
    });



    $(document).on("click",'#close-login',function(){
        $('.login-box').hide();
        $('.login-modal-bg').hide();
        $('body').css("overflow-y",'auto');
        formclear();
        RegFormClear();
        SelRegFormClear();
    });
</script>
