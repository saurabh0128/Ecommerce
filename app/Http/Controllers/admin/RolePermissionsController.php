<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\Role as roles;
use Validator;


class RolePermissionsController extends Controller
{

    //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Role Permissions',['only'=>['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $Permissions = Permission::all();
        return view('backend.role_permission.index',compact('roles','Permissions'));
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
        $AddRolePermissionvalidator = Validator::make($request->all(),[
            "role" => "required",
            "permission" => "required"
        ]);

        if($AddRolePermissionvalidator->fails())
        {
            return Response()->json(["error" => $AddRolePermissionvalidator->errors()->all() ]);
        }       

        $role = role::findById($request->role);

        
            $role->givePermissionTo($request->permission);


        return Response()->json(["success" => "data inserted successfully" ]);
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
        $EditRolePermissionvalidator = Validator::make($request->all(),[
            "role" => "required",
            // "permission" => "required"
        ]);

        if($EditRolePermissionvalidator->fails())
        {
            return Response()->json(["error" => $EditRolePermissionvalidator->errors()->all() ]);
        }       

        $role = role::findById($request->role);
        $role->syncPermissions($request->permission);


        return Response()->json(["success" => "data Updated successfully" ]);
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

    public function ajax(Request $request)
    {
        if($request->ajax() || $request->mode == 'datatable')
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
             $totalRecords = Role::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

             // Fetch records
             $records = roles::with('permission')
               ->orderBy($columnName,$columnSortOrder)
               ->where('roles.name', 'like', '%' .$searchValue . '%')
               ->select('roles.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();

            // dd($records); 

             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
              
                $id = $record->id;
                $name = $record->name;
                $permission_name ="<div class='permission-label'>";
                foreach($record->permission as $permission)
                {
                    $permission_name .=  '<span class="badge badge-info "  >'.$permission->name.'</span>' ;
                } 
                
                $permission_name .="</div>";
                // $guard_name = $record->guard_name;

                $action ="";

                if(Auth()->user()->can('Edit Role Permissions'))
                {
                    $action = '<button type="button" class="btn btn-sm btn-info EditBtn "  editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'"   >edit</button> ';
                }
                
                if(count($record->permission) != 0 )
                {
                    $data_arr[] = array(
                      "id" => $count,
                      "name" => $name,
                      "permission name" => $permission_name,
                      "action" => $action
                    );
                    $count++;
                }
                
                
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
