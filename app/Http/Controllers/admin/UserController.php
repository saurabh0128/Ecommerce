<?php 

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\City;
use App\Models\User;
use Validator;
use Image;


class UserController extends Controller
{


    //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Users',['only'=>['index']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roledata = Role::all();
       

        return view('backend.user.index',compact('roledata'));
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
            "name" => "required|min:2|alpha",
            "user_name" => "required|min:2|alpha_dash|unique:users,user_name",
            "phone_no" => "required|numeric|digits:10|unique:users,phone_no",
            "email_id" => "required|email|unique:users,email_id",
            "profile_img" => "image",
            "password" => "required|min:8",
            "c_password" => "required|same:password",
            "role" => "required"
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
        $UserData = User::with('userAddress')->where('id',$id)->get(); 

        $user = Auth::user();
        $user_id = User::find($id);
        $role = $user_id->getRoleNames();
        $role_name = isset($role[0])?$role[0]:'-';
        // $user->givePermissionTo('view order');
        // Permission::create('')
       // dd($UserData);
        return view('backend.user.show',compact('UserData','role_name'));
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

        $validator = Validator::make($request->all(),[
            "edit_name" => "required|min:2|unique:users,name,".$id,
            "edit_user_name" => "required|min:2|alpha_dash|unique:users,user_name,".$id,
            "edit_phone_no" => "required|numeric|digits:10|unique:users,phone_no,".$id,
            "edit_email_id" => "required|email|unique:users,email_id,".$id,
            "edit_profile_img" => "image|mimes:jpeg,jpg,png|max:2048",
            "edit_password" => "min:8|nullable",
            "edit_c_password" => "same:edit_password",
            "role_edit" => "required"
        ]);

        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }
        $user = User::where('id','=',$id)->first();
 
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

        return Response()->json(["success" => 'Data Updated Successfully']);


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
    }
    public function ajax(Request $request)
    {
      
        if($request->ajax() || $request->model == 'datatable')
        {
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
                $totalRecords = User::where('user_status','=','0')->select('count(*) as allcount')->count();
                $totalRecordswithFilter = User::where('user_status','=','0')->select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

                 // Fetch records
                $records = User::orderBy($columnName,$columnSortOrder)
                ->where('users.user_name', 'like', '%' .$searchValue . '%')
                ->where('user_status','=','0')
               // ->select('user_addresses.*')
                ->select('users.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

                $data_arr = array();

                //for a counter 
                $count = 1;
               // dd($records);
              
                foreach($records as $record){

                    $id = $record->id;
                    $user_name = $record->user_name;
                    $email_id = $record->email_id;
                    $profile_img = $record->profile_img;
                    $role = $record->getAllPermissions();
                    $action = '<a href="'.route('admin.user.show',$id).'"><button type="button" id="ViewBtn" class="btn btn-sm btn-warning" viewdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'" >View</button></a> ';

                    if(Auth()->user()->can('Edit Users'))
                    {
                        $action .= '<button type="button" id="EditBtn" editurl="'.route('admin.user.update',$id).'"
                       editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'" img_url="'.asset_img($profile_img,'user_img').'" class="btn btn-sm btn-info" >Edit</button> ';
                    }

                    if(Auth()->user()->can('Delete Users'))
                    {
                        $action .= '<button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> ';
                    }

                    $data_arr[] = array(
                      "id" => $count,
                      "user_name" => $user_name,
                      "email_id" => $email_id,
                      "profile_img" =>'<img src="'.asset_img($profile_img,'/thumbnail/user_img').'" alt="product image" height="100" width="100" >',
                      "action" => $action

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
        }
    }
}
