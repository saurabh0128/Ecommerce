<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use APP\Models\User;
use App\Models\SellerInfos;
use App\Models\State;
use App\Models\City;

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
        return view('backend.seller.create',compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "hello";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sellerdata = User::with('seller_infos')->where('id','=',$id)->get();
       
        return view('backend.seller.show',compact('sellerdata'));
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
        //
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

        if($request->ajax() && $request->mode == "datatabel"){

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
                $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

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
                      "profile_img" =>'<img src="'.asset('/backend_asset/user_img/'.$profile_img).'" alt="product image" height="100" width="100" >',
                      "action" => '<a href="'.route('admin.seller.show',$id).'"><button type="button" id="ViewBtn" viewurl="'.route('admin.seller.show',$id).'" class="btn btn-sm btn-warning" viewdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'">View</button></a> <button type="button" id="EditBtn" editurl="'.route('admin.user.update',$id).'"
                       editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'" class="btn btn-sm btn-info" >Edit</button> <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> '
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
            $city_data = City::where('state_id','=',$request->id)->get();

            foreach($city_data as $value)
            {
                echo "<option value=".$value->id.">".$value->city_name."</option>";
            }
        }
    }
}
