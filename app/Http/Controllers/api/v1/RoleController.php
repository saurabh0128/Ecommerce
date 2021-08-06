<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\Role as roll;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        }else{
            Role::create(['name'=>$request->role_name ]);
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
            "role_name" => 'required|unique:roles,name,'.$id
        ]);
        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all()]);
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
        return Response()->json(['success'=>'Data deleted Successfully']);
    }
}
