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
                    <div class="tab-pane" id="sign-up">
                    <form method="post" accept-charset="utf-8">
                        
                        <div class="form-group">
                            <label>Your Name*</label>
                            <input type="text" v-model="RegForm.name"  class="form-control" name="reg_name" id="reg_name" required>
                        </div>

                        <div class="form-group">
                            <label>Your Email Address *</label>
                            <input type="text" v-model="RegForm.email"  class="form-control" name="reg_email" id="reg_email" required>
                        </div>
                        <div class="form-group">
                            <label>Username *</label>
                            <input  v-model="RegForm.username"  type="text" class="form-control" name="reg_username" id="reg_username" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input v-model="RegForm.phone_number" type="text" class="form-control" name="reg_ph_number" id="reg_ph_number" required>
                        </div>
                        <div class="form-group">
                            <label>Password *</label>
                            <input v-model="RegForm.password" type="text" class="form-control" name="reg_password" id="reg_password" required>
                        </div>
                        <div class="form-group mb-5">
                            <label>Confirm Password *</label>
                            <input v-model="RegForm.confirm_password" type="text" class="form-control" name="reg_confirm_password" id="reg_confirm_password" required>
                        </div>
                        <p>Your personal data will be used to support your experience 
                            throughout this website, to manage access to your account, 
                            and for other purposes described in our <a href="#" class="text-primary">privacy policy</a>.</p>
                        <a href="#" class="d-block mb-5 text-primary">Signup as a vendor?</a>
                        <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                            <input type="checkbox" class="custom-checkbox" id="agree" name="agree" required="">
                            <label for="agree" class="font-size-md">I agree to the <a  href="#" class="text-primary font-size-md">privacy policy</a></label>
                        </div>
                
                        <button @click.prevent="register" type="submit" class="btn btn-primary btn-block" >Sign Up</button>
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
                    profile_img:'',
                    email:'',
                    username:'',
                    phone_number:'',
                    password:'',
                    confirm_password:''
                },  
                Regerrors:[]
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
                console.log(this.RegForm);
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

    $(document).on("click",'#close-login',function(){
        $('.login-box').hide();
        $('.login-modal-bg').hide();
        $('body').css("overflow-y",'auto');
        formclear();
    });
</script>
