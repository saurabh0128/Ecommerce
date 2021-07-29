<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;


use App\Models\Role as roll;


use Spatie\Permission\Models\Role;



class RoleController extends Controller
{

    //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Roles',['only'=>['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.roll.index');
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

            "role_name" => "required|unique:roles,name"

        ]);

        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }

        Role::create(['name'=>$request->role_name ]);

        return Response()->json(["success"=>"Data Inserted Successfully"]);

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
        $EditValidator = Validator::make($request->all(),[

            "role_name" => 'required|unique:roles,name,'.$id
        ]);

        if($EditValidator->fails())
        {
            return Response()->json(["error"=>$EditValidator->errors()->all()]);
        }

        $role = roll::where('id','=',$id)->first();
        $role->name = $request->role_name;
        $role->save();

        return Response()->json(['success'=>'Data Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        roll::where('id','=',$id)->delete();
    }

    //it is used for pass data from database  to a datatable
    public function ajax(Request $request)
    {
        
        if ( $request->ajax() || $request->mode == 'datatable') {
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
             $totalRecords = roll::select('count(*) as allcount')->count();
             $totalRecordswithFilter = roll::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();


             // Fetch records
             $records = roll::orderBy($columnName,$columnSortOrder)
               ->where('roles.name', 'like', '%' .$searchValue . '%')
               ->select('roles.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();

             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
                $id = $record->id;
                $name = $record->name;
                $guard_name = $record->guard_name;

                $action ="";

                if(Auth()->user()->can('Edit Roles'))
                {    
                        $action .= '<button type="button" id="EditBtn" editurl="'.route('admin.role.update',$id).'"
                        editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'"  class="btn btn-sm btn-info" >Edit</button> ';
                }

                if(Auth()->user()->can('Delete Roles'))
                {
                        $action .= '<button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> ';
                }

                $data_arr[] = array(
                  "id" => $count,
                  "name" => $name,
                  "guard_name" => $guard_name,
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
