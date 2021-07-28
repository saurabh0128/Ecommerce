<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerCategory;
use App\Models\Category;
use APP\Models\User;
use App\Models\SellerInfos;
use App\Models\State;
use App\Models\City;
use App\Models\Role;
use Validator;


class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.seller.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state=State::all();
        $roledata = Role::all();
        return view('backend.seller.create',compact('state','roledata'));
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
            $request->validate([
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
                'Role' => 'required'
            ]);
        }else{
            
            $request->validate([
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

       
        $user_data = new User;
        $seller_data = new SellerInfos;
        
        $onlyImgName = pathinfo($request->user_profile->getClientOriginalName(),PATHINFO_FILENAME);
        $imageExt = $request->user_profile->getClientOriginalExtension();
        $imageName = $onlyImgName."-".time().".".$imageExt;
        $request->user_profile->move(public_path('/backend_asset/user_img/'),$imageName);        

        $user_data->name=$request->name;
        $user_data->user_name=$request->user_name;
        $user_data->phone_no=$request->contect_on;
        $user_data->email_id=$request->email_id;
        $user_data->password=Hash::make($request->password);
        $user_data->profile_img=$imageName;
        $user_data->user_status=1;

        $user_data->save();

        $user_data->assignRole($request->role);

        $onlyImgName = pathinfo($request->id_proof->getClientOriginalName(),PATHINFO_FILENAME);
        $imageExt = $request->id_proof->getClientOriginalExtension();
        $imageNameSeller = $onlyImgName."-".time().".".$imageExt;
        $request->id_proof->move(public_path('/backend_asset/seller_img/'),$imageNameSeller);

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
        $seller_data->id_proof = $imageNameSeller;
        $seller_data->is_permisssion_sell = $request->is_permission_sell;

        $seller_data->save();

        return redirect()->route('admin.seller.index')->with('success','Data Inserted SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sellerdata = User::with(['seller_infos','category'])->where('id','=',$id)->get();
       // dd($sellerdata);    
        $user_id = User::find($id);
        $role = $user_id->getRoleNames();
        $role_name = isset($role[0])?$role[0]:'-';
        return view('backend.seller.show',compact('sellerdata','role_name'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $sellerdata = User::with('seller_infos')->where('id','=',$id)->firstOrFail();
        $citydata= City::find($sellerdata->seller_infos->city_id);
        $statedata= State::all();
        $allcitydata = city::all();

        if(strlen($sellerdata->seller_infos->id_proof_no) == 12){
            $proof_name = 0;
        }else{
            $proof_name = 1;
        }
        // $seller = User::find($id);
        // $sellerdata->assignRole('seller');
        $SellerRole=  $sellerdata->getRoleNames();

        $roles = Role::all();
    
        return view('backend.seller.edit',compact('sellerdata','citydata','statedata','allcitydata','proof_name','roles','SellerRole'));
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
            
            $request->validate([

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
            
            
            $request->validate([
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

        $user_data = User::find($id);
        $seller_data = SellerInfos::where('user_id','=',$id)->first();
        

        // dd($user_data);
        // dd($seller_data);
        if($request->hasFile('user_profile'))
        { 
            $onlyImgName = pathinfo($request->user_profile->getClientOriginalName(),PATHINFO_FILENAME);
            $imageExt = $request->user_profile->getClientOriginalExtension();
            $imageName = $onlyImgName."-".time().".".$imageExt;
            $request->user_profile->move(public_path('/backend_asset/user_img/'),$imageName);
            $user_data->profile_img=$imageName;        
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

        return redirect()->route('admin.seller.index')->with('success','Data Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $error = User::where('id','=',$id)->delete();

        }catch(\Illuminate\Database\QueryException $error)
        {
        
            return Response()->json(["error" => "Delete Child Records First"]);
        }

        return Response()->json(["success" => "Delete Record SuccessFully"]);
    }
    public function ajax(Request $request){

        if($request->ajax() && $request->mode == "datatable"){

         $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); 

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // Total records
                $totalRecords = User::select('count(*) as allcount')->count();
                $totalRecordswithFilter = User::where('user_status','=','1')->select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

                 // Fetch records
                $records = User::orderBy($columnName,$columnSortOrder)
                ->where('users.user_name', 'like', '%' .$searchValue . '%')
                ->where('user_status','=','1')
                ->select('users.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

                $data_arr = array();

                //for a counter 
                $count = 1;
                 foreach($records as $record){

                    $id = $record->id;
                    $user_name = $record->user_name;
                    $email_id = $record->email_id;
                    $profile_img = $record->profile_img;
                   
                    $data_arr[] = array(
                      "id" => $count,
                      "user_name" => $user_name,
                      "email_id" => $email_id,
                      "profile_img" =>'<img src="'.asset_img($profile_img,'user_img').'" alt="product image" height="100" width="100" >',
                      "action" => '<a href="'.route('admin.seller.show',$id).'"><button type="button" id="ViewBtn" viewurl="'.route('admin.seller.show',$id).'" class="btn btn-sm btn-warning" viewdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'">View</button></a> <a href="'.route('admin.seller.edit',$id).'"><button type="button" id="EditBtn" editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'" class="btn btn-sm btn-info" >Edit</button></a> <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> '
                    );
                    $count++;
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );

                echo json_encode($response);
                exit;
        }elseif($request->ajax() && $request->mode == "chek_state")
        {
            $city_data = City::where('state_id','=',$request->state_id)->get();


           
            $str = "";   
            foreach($city_data as $value)
            {
                $str .= "<option value=".$value->id.">".$value->city_name."</option>";
            }
            echo $str;
        }


    }
}
