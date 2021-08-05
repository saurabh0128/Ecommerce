<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\SellerInfos;
use App\Models\User;
use Validator;
use Image;

class SellerController extends Controller
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
        if($request->proof == 0)
        {
             $validator = Validator::make($request->all(),[
                'name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'user_name' => 'required|alpha_dash|min:2|max:100|unique:users,user_name',
                'contect_on' => 'required|numeric|digits:10|unique:users,phone_no',
                'user_profile' => 'required|image|max:2048',
                'companie_name' => 'required|min:2|max:100',
                'address' => 'required|min:2|max:200',
                'state' => 'required',
                'city' => 'required',
                'email_id'=> 'email|unique:users,email_id',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'bank_name' => 'required|min:3|regex:/^[\pL\s]+$/u',
                'account_no' => 'required|numeric|digits:16|unique:seller_infos,account_no',
                'ifsc_code' => 'required|regex:/^[A-Za-z]{4}\d{7}$/',
                'account_holder_name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'id_proof_no' => 'required|digits:12|unique:seller_infos,id_proof_no',
                'id_proof' => 'image|max:2048',
                'gst_no' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                'role' => 'required'
            ]);
        }else{
            
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'user_name' => 'required|alpha_dash|min:2|max:100',
                'contect_on' => 'required|numeric|digits:10',
                'user_profile' => 'required|image|max:2048',
                'companie_name' => 'required|min:2|max:100',
                'address' => 'required|min:2|max:200',
                'state' => 'required',
                'city' => 'required',
                'email_id'=> 'email|unique:users,email_id',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'bank_name' => 'required|min:3|regex:/^[\pL\s]+$/u',
                'account_no' => 'required|numeric|digits:16|unique:seller_infos,account_no',
                'ifsc_code' => 'required|regex:/^[A-Za-z]{4}\d{7}$/',
                'account_holder_name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'id_proof_no' => 'required|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/|unique:seller_infos,id_proof_no',
                'id_proof' => 'image|max:2048',
                'gst_no' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                'role' => 'required'
            ]);
        }


        if($validator->fails())
        {
            return Response()->json(['error'=>$validator->errors()->all()]);
        }else{

            $user_data = new User;
            $seller_data = new SellerInfos;
            
            // for seller profile images
            $onlyImgName = pathinfo($request->user_profile->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->user_profile->getClientOriginalExtension();
            $imageName = $onlyImgName."-".time().".".$imageExt;
            $request->user_profile->move(public_path('/backend_asset/seller_img/'),$imageName);        
            $user_data->profile_img=$imageName;

            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/seller_img/'.$imageName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/seller_img/'.$imageName);

            $user_data->name=$request->name;
            $user_data->user_name=$request->user_name;
            $user_data->phone_no=$request->contect_on;
            $user_data->email_id=$request->email_id;
            $user_data->password=Hash::make($request->password);
            $user_data->user_status=1;

            $user_data->save();

            $user_data->assignRole($request->role);

            // for seller ID Proof images
            $onlyImgName = pathinfo($request->id_proof->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->id_proof->getClientOriginalExtension();
            $imageNameSeller = $onlyImgName."-".time().".".$imageExt;
            $request->id_proof->move(public_path('/backend_asset/seller_img/'),$imageNameSeller);
            $seller_data->id_proof = $imageNameSeller;

            // for thumbnail create and save 
            $img = Image::make(public_path('/backend_asset/seller_img/'.$imageNameSeller));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/seller_img/'.$imageNameSeller);


            $seller_data->user_id = $user_data->id;
            $seller_data->gst_no = $request->gst_no;
            $seller_data->company_name = $request->companie_name;
            $seller_data->address = $request->address;
            $seller_data->city_id =$request->city;
            $seller_data->bank_name = $request->bank_name;
            $seller_data->account_no = $request->account_no;
            $seller_data->ifsc_code = $request->ifsc_code;
            $seller_data->ac_holder_name = $request->account_holder_name;
            $seller_data->id_proof_no = $request->id_proof_no;
            $seller_data->is_permisssion_sell = $request->is_permission_sell;

            $seller_data->save();

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
        if($request->proof == 0)
        {
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'user_name' => 'required|alpha_dash|min:2|max:100|unique:users,user_name,'.$id,
                'contect_on' => 'required|numeric|digits:10|unique:users,phone_no,'.$id,
                'user_profile' => 'image|max:2048',
                'companie_name' => 'required|min:2|max:100',
                'address' => 'required|min:2|max:200',
                'state' => 'required',
                'city' => 'required',
                'email_id'=> 'email|unique:users,email_id,'.$id,
                'password'=> 'min:8|nullable',
                'confirm_password' => 'same:password',
                'bank_name' => 'required|min:3|regex:/^[\pL\s]+$/u',
                'account_no' => 'required|numeric|digits:16|unique:seller_infos,account_no,'.$id.',user_id',
                'ifsc_code' => 'required|regex:/^[A-Za-z]{4}\d{7}$/',
                'account_holder_name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                'id_proof_no' => 'required|digits:12|unique:seller_infos,id_proof_no,'.$id.',user_id',
                'id_proof' => 'image|max:2048',
                'gst_no' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                 'user_name' => 'required|alpha_dash|min:2|max:100|unique:users,user_name,'.$id,
                'contect_on' => 'required|numeric|digits:10|unique:users,phone_no,'.$id,
                'user_profile' => 'image|max:2048',
                'companie_name' => 'required|min:2|max:100',
                'address' => 'required|min:2|max:200',
                'state' => 'required',
                'city' => 'required',
                'email_id'=> 'email|unique:users,email_id,'.$id,
                'password'=> 'min:8|nullable',
                'confirm_password' => 'same:password',
                'bank_name' => 'required|min:3|regex:/^[\pL\s]+$/u',
                'account_no' => 'required|numeric|digits:16|unique:seller_infos,account_no,'.$id.',user_id',
                'ifsc_code' => 'required|regex:/^[A-Za-z]{4}\d{7}$/',
                'account_holder_name' => 'required|min:2|max:100|regex:/^[\pL\s]+$/u',
                 'id_proof_no' => 
                 'required|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/|unique:seller_infos,id_proof_no,'.$id.',user_id',
                'id_proof' => 'image|max:2048',
                'gst_no' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'
            ]);
        }

        if($validator->fails())
        {
            return Response()->json(['error'=>$validator->errors()->all()]);
        }else{
            $user_data = User::find($id);
            $seller_data = SellerInfos::where('user_id','=',$id)->first();
            

            // dd($user_data);
            // dd($seller_data);
            if($request->hasFile('user_profile'))
            { 
                $onlyImgName = pathinfo($request->user_profile->getClientOriginalName(),PATHINFO_FILENAME);
                $imageExt = $request->user_profile->getClientOriginalExtension();
                $imageName = $onlyImgName."-".time().".".$imageExt;
                $request->user_profile->move(public_path('/backend_asset/seller_img/'),$imageName);
                $user_data->profile_img=$imageName;

                // for thumbnail create and save 
                $img = Image::make(public_path('/backend_asset/seller_img/'.$imageName));
                $img->resize(150,150);
                $img->save(public_path().'/backend_asset/thumbnail/seller_img/'.$imageName);        
            }

            $user_data->name=$request->name;
            $user_data->user_name=$request->user_name;
            $user_data->phone_no=$request->contect_on;
            $user_data->email_id=$request->email_id;
            $user_data->password=Hash::make($request->password);
           
            $user_data->user_status=1;

            $user_data->save();

            $user_data->syncRoles($request->role);

            if($request->hasFile('id_proof'))
            {
                $onlyImgName = pathinfo($request->id_proof->getClientOriginalName(),PATHINFO_FILENAME);
                $imageExt = $request->id_proof->getClientOriginalExtension();
                $imageNameSeller = $onlyImgName."-".time().".".$imageExt;
                $request->id_proof->move(public_path('/backend_asset/seller_img/'),$imageNameSeller);
                $seller_data->id_proof = $imageNameSeller;

                // for thumbnail create and save 
                $img = Image::make(public_path('/backend_asset/seller_img/'.$imageNameSeller));
                $img->resize(150,150);
                $img->save(public_path().'/backend_asset/thumbnail/seller_img/'.$imageNameSeller); 
            }

            
            $seller_data->gst_no = $request->gst_no;
            $seller_data->company_name = $request->companie_name;
            $seller_data->address = $request->address;
            $seller_data->city_id =$request->city;
            $seller_data->bank_name = $request->bank_name;
            $seller_data->account_no = $request->account_no;
            $seller_data->ifsc_code = $request->ifsc_code;
            $seller_data->ac_holder_name = $request->account_holder_name;
            $seller_data->id_proof_no = $request->id_proof_no;
            
            $seller_data->is_permisssion_sell = $request->is_permission_sell;

            $seller_data->save();

            return Response()->json(["success"=>"Data Updated Successfully"]);
        }
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
}
