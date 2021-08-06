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

        // dd($AllSettingsData[array_search('home_title',array_column($AllSettingsData,'setting_name'))]['setting_value']);
      
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
    public function store(Request $request)
    {
         $request->validate([
            "home_title" => "required",
            "home_desc" => "required",
            "logo" => "image",
            // "email" =>  "required",
            // "mail_driver" =>  "required",
            // "mail_host" => "required",
            // "mail_port" => "required",
            // "mail_username" => "required",
            // "mail_password" => "required",
            // "mail_encryption" => "required",
            // "mail_address" => "required",
            // "mail_name" => "required"
        ]);

         $AllSettings = $request->all();

         foreach( $AllSettings as $key => $value )
         {
            if($key == '_token')
            {
                continue;
            }
            
            $setting = Setting::where('setting_name',$key)->first();
            if($setting != Null)
            {
                $setting->setting_value = $value;
                $setting->save(); 
            }
            else{
                
                $NewSetting = new Setting();
                $NewSetting->setting_name = $key;
                $NewSetting->setting_value = $value;
                $NewSetting->save();
            }
         }
         
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
