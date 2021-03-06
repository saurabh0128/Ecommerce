<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Session;
use App\Models\User;
use Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.profile.index');
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
        //
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
       if(!is_null($request->password))
       {
            $request->validate([
                "password" => "required",
                "new_password" => "required",
                "confirm_password" => "required|same:new_password",
                "name" => "required|min:2|max:100|regex:/^[\pL\s]+$/u",
                "username" => "required|alpha_dash|min:2|max:100|unique:users,user_name,".$id,
                "phone_no" => "required|numeric|digits:10|unique:users,phone_no,".$id,
                "email_id" => "email|unique:users,email_id,".$id,
              
            ]);
            $user_password = User::find($id); 
            if(!Hash::check($request->password,auth()->user()->password))
            {   
                return back()->with('error','Old Password Not Match');
            }
       }else{

            $request->validate([
                    "name" => "required|min:2|max:100|regex:/^[\pL\s]+$/u",
                    "username" => "required|alpha_dash|min:2|max:100|unique:users,user_name,".$id,
                    "phone_no" => "required|numeric|digits:10|unique:users,phone_no,".$id,
                    "email_id" => "required|email|unique:users,email_id,".$id,
                    "profile_img" => "image",
                ]);
       }
       $userdata = User::find($id);


        if($request->hasFile('profile_img'))
        {
            $onlyImgName = pathinfo($request->profile_img->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->profile_img->getClientOriginalExtension();
            $imageName = $onlyImgName."-".time().".".$imageExt;
            $request->profile_img->move(public_path('/backend_asset/user_img/'),$imageName);
            $userdata->profile_img = $imageName;

            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/user_img/'.$imageName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/user_img/'.$imageName);
        }

        $userdata->name = $request->name;
        $userdata->user_name = $request->username;
        $userdata->email_id = $request->email_id;
        $userdata->phone_no = $request->phone_no;
        $userdata->password = Hash::make($request->new_password);

        $userdata->save();
      
       return redirect()->route('admin.profile.index')->with('com','Data Updated SuccessFully');
        
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
