<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Permission as Permissions;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\QueryException;


use Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.permission.index');
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

        // insert permission code
        $AddPermissionValidator = Validator::make($request->all(),[
            'permission_name' => 'required|min:3|max:100|unique:permissions,name'
        ]);

        if($AddPermissionValidator->fails())
        {
            return Response()->json(["error"=>$AddPermissionValidator->errors()->all()]);
        }

        Permission::create(['name'=>$request->permission_name]);

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
        $EditPermissionValidator = Validator::make($request->all(),[
            'edit_permission_name' => 'required|min:3|max:100|unique:permissions,name,'.$id
        ]);

        if($EditPermissionValidator->fails())
        {
            return Response()->json(["error"=>$EditPermissionValidator->errors()->all() ]);
        }

        $Permission = Permissions::where('id','=',$id)->first();
        $Permission->name = $request->edit_permission_name;
        $Permission->save();
        return Response()->json(['success'=>'Data Inserted Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Permissions::where('id','=',$id)->delete();
        } catch (Exception $e) {
             return Response()->json(["error"=> 'You cannot delete a Permission directly , First delete a related records ']);
        }
        
    }


    public function ajax(Request $request){

        if($request->ajax()|| $request->mode == 'datatable'){

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
             $totalRecords = Permissions::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Permissions::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

             // Fetch records
             $records = Permissions::orderBy($columnName,$columnSortOrder)
               ->where('permissions.name', 'like', '%' .$searchValue . '%')
               ->select('permissions.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();

             $data_arr = array();

            // foreach($records as $record){
            //     echo $record->name;
            // }
             //for a counter 
             $count = 1;

             foreach($records as $record){
                $id = $record->id;
                $name = $record->name;
                $guard_name = $record->guard_name;

                $data_arr[] = array(
                  "id" => $count,
                  "name" => $name,
                  "guard_name" => $guard_name,
                  "action" => '<button type="button" id="EditBtn" editurl="'.route('admin.permission.update',$id).'"
                   editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'"  class="btn btn-sm btn-info" >Edit</button> <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button>'
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
