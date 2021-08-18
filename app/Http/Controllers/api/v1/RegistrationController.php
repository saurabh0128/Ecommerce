<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class RegistrationController extends Controller
{
    public function userRegistration(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
        "name" => "required|min:2",
        "username" => "required|min:2|alpha_dash|unique:users,user_name",
        "phone_number" => "required|numeric|digits:10|unique:users,phone_no",
        "email" => "required|email|unique:users,email_id",
        "profile_img" => "image",
        "password" => "required|min:8",
        "confirm_password" => "required|same:password",
        'agree' =>"required"
        ]);

        
        if($validator->fails())
        {
            return Response()->json(['status'=>false,'error'=>$validator->errors()]);
        }else{
            $user = new User;
            

            // // for img upload 
            // $onlyImgName = pathinfo($request->profile_img->getClientOriginalName(),PATHINFO_FILENAME);
            // $imageExt = $request->profile_img->getClientOriginalExtension();
            // $imageName = $onlyImgName."-".time().".".$imageExt;
            // $request->profile_img->move(public_path('/backend_asset/user_img/'),$imageName); 
            // $user->profile_img = $imageName;
    
            // // for thumbnail create and save 
            // $img = Image::make(public_path('/backend_asset/user_img/'.$imageName));
            // $img->resize(150,150);
            // $img->save(public_path().'/backend_asset/thumbnail/user_img/'.$imageName);


            $user->name = $request->name;
            $user->user_name = $request->username;
            $user->phone_no = $request->phone_number;
            $user->email_id = $request->email;
            $user->password = Hash::make($request->password);
            if($request->user_status == "customer"){
                $user->user_status = 0;
            }elseif($request->user_status == "seller"){
                $user->user_status = 1;
            }

            $user->save();
            $user->assignRole($request->user_status);
             
            return Response()->json(['status'=>true,"message"=>"Register Successfully"]);
            
        }
    }
}
