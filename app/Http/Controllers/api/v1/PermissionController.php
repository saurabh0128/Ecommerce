<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use App\Models\Permission as Permissions;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $permission = Permission::all();

        return Response()->json($permission);
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
        $Validator = Validator::make($request->all(),[
            'permission_name' => 'required|min:3|max:100|unique:permissions,name'
        ]);

        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all()]);
        }else{
            Permission::create(['name'=>$request->permission_name]);

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
        $Validator = Validator::make($request->all(),[
            'edit_permission_name' => 'required|min:3|max:100|unique:permissions,name,'.$id
        ]);

        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all() ]);
        }else{
            $Permission = Permissions::where('id','=',$id)->first();
            $Permission->name = $request->edit_permission_name;
            $Permission->save();
            return Response()->json(['success'=>'Data Inserted Successfully']);
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
        try{
            Permissions::where('id','=',$id)->delete();
            return Response()->json(['success'=>'Data Deleted Successfully']);
        } catch (Exception $e) {
            return Response()->json(["error"=> 'You cannot delete a Permission directly , First delete a related records ']);
        }
    }
}
