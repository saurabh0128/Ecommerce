<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
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
        $validator = Validator::make($request->all(),[
            "name" => "required|min:2",
            "user_name" => "required|min:2|alpha_dash|unique:users,user_name",
            "phone_no" => "required|numeric|digits:10|unique:users,phone_no",
            "email_id" => "required|email|unique:users,email_id",
            "profile_img" => "image",
            "password" => "required|min:8",
            "c_password" => "required|same:password",
           // "role" => "required"
        ]);

        
        if($validator->fails())
        {
            return Response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $user = new User;
            
            // for img upload 
            $onlyImgName = pathinfo($request->profile_img->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->profile_img->getClientOriginalExtension();
            $imageName = $onlyImgName."-".time().".".$imageExt;
            $request->profile_img->move(public_path('/backend_asset/user_img/'),$imageName); 
            $user->profile_img = $imageName;
    
            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/user_img/'.$imageName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/user_img/'.$imageName);


            $user->name = $request->name;
            $user->user_name = $request->user_name;
            $user->phone_no = $request->phone_no;
            $user->email_id = $request->email_id;
            $user->password = Hash::make($request->password);
            $user->user_status = 0;

            $user->save();
            $user->assignRole($request->role);
             
            return Response()->json(["success"=>"Data Inserted Successfully"]);
        }
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
       
        $user = User::where('id','=',$id)->firstOrFail();


        $user_name = $request->edit_name;
 
        if($request->hasFile('edit_profile_img'))
        {
            $onlyImgName = pathinfo($request->edit_profile_img->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->edit_profile_img->getClientOriginalExtension();
            $imageName = $onlyImgName."-".time().".".$imageExt;
            $request->edit_profile_img->move(public_path('/backend_asset/user_img/'),$imageName);
            $user->profile_img = $imageName;

            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/user_img/'.$imageName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/user_img/'.$imageName);
        }
        if($request->edit_password != null)
        {
            $user->password = Hash::make($request->edit_c_password);
        }
         $user->name = $request->edit_name;
        $user->user_name = $request->edit_user_name;
        $user->email_id = $request->edit_email_id;
        $user->phone_no = $request->edit_phone_no;
        
        $user->save();
        $user->syncRoles($request->role_edit);

        return Response()->json(["success"=>"Data Updated Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id','=',$id)->delete();

        return Response()->json(["success"=>"Delete Data Successfully"]);        
    }
    public function test()
    {
        $userdata = User::all();
        
        return Response()->json(["User" => $userdata]);
    }
}
