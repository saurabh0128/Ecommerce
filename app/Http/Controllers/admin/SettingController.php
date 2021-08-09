<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AllSettingsData = Setting::all()->toArray();

        // dd($AllSettingsData[array_search('paypal_details',array_column($AllSettingsData,'setting_name'))]['setting_value']);
        return view('backend.setting.index',compact('AllSettingsData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //insert all seting if not in database otherwise update setting value
    public function store(Request $request)
    {

        // dd($request->cod_active);

        $request->validate([
            "home_title" => "required",
            "home_desc" => "required",
            "logo" => "image",
        ]);

        $Setting_home_title = Setting::where('setting_name','home_title')->first();
        if(!$Setting_home_title)
        {
            $Setting_home_title = new Setting();
            $Setting_home_title->setting_name = 'home_title';
        }
        $Setting_home_title->setting_value = $request->home_title;
        $Setting_home_title->save();

        $Setting_home_desc = Setting::where('setting_name','home_desc')->first();
        if(!$Setting_home_desc)
        {
            $Setting_home_desc = new Setting();
            $Setting_home_desc->setting_name = 'home_desc';
        }
        $Setting_home_desc->setting_value = $request->home_desc;
        $Setting_home_desc->save();


        //if image found move it to logo image folder
        if($request->hasFile('logo'))
        {
            $Setting_logo = Setting::where('setting_name','logo')->first();
            if(!$Setting_logo)
            {
                $Setting_logo = new Setting();
                $Setting_logo->setting_name = 'logo';
            }

            $onlyImgName = pathinfo($request->logo->getClientOriginalName(),PATHINFO_FILENAME);
            $imgExtension = $request->logo->getClientOriginalExtension(); 
            $imgName = $onlyImgName."-".time().".".$imgExtension;
            $request->logo->move(public_path('backend_asset/logo_images'),$imgName);

            $Setting_logo->setting_value = $imgName;
            $Setting_logo->save();
        }
        

        $Setting_currency = Setting::where('setting_name','currency')->first();
        if(!$Setting_currency)
        {
            $Setting_currency = new Setting();
            $Setting_currency->setting_name = 'currency';
        }
        $Setting_currency->setting_value = $request->currency;
        $Setting_currency->save();


        $Setting_currency_symbol = Setting::where('setting_name','currency_symbol_placement')->first();
        if(!$Setting_currency_symbol)
        {
            $Setting_currency_symbol = new Setting();
            $Setting_currency_symbol->setting_name = 'currency_symbol_placement';
        }
        $Setting_currency_symbol->setting_value = $request->currency_symbol_placement;
        $Setting_currency_symbol->save();



        $Setting_email = Setting::where('setting_name','email')->first();
        if(!$Setting_email)
        {
            $Setting_email = new Setting();
            $Setting_email->setting_name = 'email';
        }
        $Setting_email->setting_value = $request->email;
        $Setting_email->save();


        $setting_mail_driver = Setting::where('setting_name','mail_driver')->first();
        if(!$setting_mail_driver)
        {
            $setting_mail_driver = new Setting();
            $setting_mail_driver->setting_name = 'mail_driver';
        }
        $setting_mail_driver->setting_value = $request->mail_driver;
        $setting_mail_driver->save();


        $setting_mail_host = Setting::where('setting_name','mail_host')->first();
        if(!$setting_mail_host)
        {
            $setting_mail_host = new Setting();
            $setting_mail_host->setting_name = 'mail_host';
        }
        $setting_mail_host->setting_value = $request->mail_host;
        $setting_mail_host->save();


        $setting_mail_port = Setting::where('setting_name','mail_port')->first();
        if(!$setting_mail_port)
        {
            $setting_mail_port = new Setting();
            $setting_mail_port->setting_name = 'mail_port';
        }
        $setting_mail_port->setting_value = $request->mail_port;
        $setting_mail_port->save();


        $setting_mail_username = Setting::where('setting_name','mail_username')->first();
        if(!$setting_mail_username)
        {
            $setting_mail_username = new Setting();
            $setting_mail_username->setting_name = 'mail_username';
        }
        $setting_mail_username->setting_value = $request->mail_username;
        $setting_mail_username->save();


        $setting_mail_password = Setting::where('setting_name','mail_password')->first();
        if(!$setting_mail_password)
        {
            $setting_mail_password = new Setting();
            $setting_mail_password->setting_name = 'mail_password';
        }
        $setting_mail_password->setting_value = $request->mail_password;
        $setting_mail_password->save();

        $setting_mail_encryption = Setting::where('setting_name','mail_encryption')->first();
        if(!$setting_mail_encryption)
        {
            $setting_mail_encryption = new Setting();
            $setting_mail_encryption->setting_name = 'mail_encryption';
        }
        $setting_mail_encryption->setting_value = $request->mail_encryption;
        $setting_mail_encryption->save();


        $setting_mail_address = Setting::where('setting_name','mail_address')->first();
        if(!$setting_mail_address)
        {
            $setting_mail_address = new Setting();
            $setting_mail_address->setting_name = 'mail_address';
        }
        $setting_mail_address->setting_value = $request->mail_address;
        $setting_mail_address->save();


        $setting_mail_name = Setting::where('setting_name','mail_name')->first();
        if(!$setting_mail_name)
        {
            $setting_mail_name = new Setting();
            $setting_mail_name->setting_name = 'mail_name';
        }
        $setting_mail_name->setting_value = $request->mail_name;
        $setting_mail_name->save();



        $setting_cod_active = Setting::where('setting_name','cod_active')->first();
        if(!$setting_cod_active)
        {
            $setting_cod_active = new Setting();
            $setting_cod_active->setting_name = 'cod_active';
        }
        $setting_cod_active->setting_value = isset($request->cod_active)?1:0;
        $setting_cod_active->save();



        $setting_paypal_active = Setting::where('setting_name','paypal_active')->first();
        if(!$setting_paypal_active)
        {
            $setting_paypal_active = new Setting();
            $setting_paypal_active->setting_name = 'paypal_active';
        }
        $setting_paypal_active->setting_value = isset($request->paypal_active)?1:0;
        $setting_paypal_active->save();


        $setting_paypal_details = Setting::where('setting_name','paypal_details')->first();
        if(!$setting_paypal_details)
        {
            $setting_paypal_details = new Setting();
            $setting_paypal_details->setting_name = 'paypal_details';
        }
        $PaypalDetailArray = [
            'app_id' =>  $request->paypal_app_id,
            'username' => $request->paypal_username,
            'password' => $request->paypal_password,
            'secret' => $request->paypal_secret,
            'certificate' => $request->paypal_certificate,
        ];
        $setting_paypal_details->setting_value = $PaypalDetailArray;
        $setting_paypal_details->save();


        $setting_paypal_mode = Setting::where('setting_name','paypal_mode')->first();
        if(!$setting_paypal_mode)
        {
            $setting_paypal_mode = new Setting();
            $setting_paypal_mode->setting_name = 'paypal_mode';
        }
        $setting_paypal_mode->setting_value = isset($request->paypal_mode)?1:0;
        $setting_paypal_mode->save();



        $setting_stripe_active = Setting::where('setting_name','stripe_active')->first();
        if(!$setting_stripe_active)
        {
            $setting_stripe_active = new Setting();
            $setting_stripe_active->setting_name = 'stripe_active';
        }
        $setting_stripe_active->setting_value = isset($request->stripe_active)?1:0;
        $setting_stripe_active->save();



        $setting_stripe_mode = Setting::where('setting_name','stripe_mode')->first();
        if(!$setting_stripe_mode)
        {
            $setting_stripe_mode = new Setting();
            $setting_stripe_mode->setting_name = 'stripe_mode';
        }
        $setting_stripe_mode->setting_value = isset($request->stripe_mode)?1:0;
        $setting_stripe_mode->save();



        $setting_stripe_details = Setting::where('setting_name','stripe_details')->first();
        if(!$setting_stripe_details)
        {
            $setting_stripe_details = new Setting();
            $setting_stripe_details->setting_name = 'stripe_details';
        }
        $StripeDetailArray = [
            'live_stripe_key' => $request->live_stripe_key,
            'live_secret_key' => $request->live_stripe_secret_key,
            'test_stripe_key' => $request->test_stripe_key,
            'test_secret_key' => $request->test_stripe_secret_key
        ];
        $setting_stripe_details->setting_value = $StripeDetailArray;
        $setting_stripe_details->save();


        
         
        return redirect()->route('admin.setting.index')->with("success","Setting Save Successfully");  
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
