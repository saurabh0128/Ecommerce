<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
    public function userLogin(Request $request)
    {


        $LoginValidator = Validator::make($request->all(),[
            'username' => 'required|min:2',
            'password' => 'required|min:2'
        ]);

        if($LoginValidator->fails())
        {
            return Response()->json(["status"=>false,"error"=> $LoginValidator->errors()->all()]);
        }
        

        if(Auth::attempt(['user_name'=>$request->username, 'password'=>$request->password]))
        { 
            if(Auth::user()->hasRole('customer'))
            {
                $access = Auth::user()->createToken('authToken')->accessToken;
                return Response()->json(["status"=>true,'info'=>Auth::user(),'access_token'=>$access]);
            }
        }

        return Response()->json(["status"=>false,'error' => ['The Provided Credential are wrong']]);
    }
}
