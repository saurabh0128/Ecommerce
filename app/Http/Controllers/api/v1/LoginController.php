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
        $login = $request->validate([
            'user_name' => 'required|min:2',
            'password' => 'required|min:2'

        ]);
        if(!Auth::attempt($login)){
            return Response(['message' => 'Not Right']);
        }

        $access = Auth::user()->createToken('authToken')->accessToken;
    
        return Response(['user'=>Auth::user(),'access_token'=>$access]);


       // return $request->user_name;
    }
}
