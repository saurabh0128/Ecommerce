<?php
 
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use App\Models\Coupone;

use Illuminate\Database\QueryException;

use Carbon\carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([    
            "coupon_code" => "required|min:3|max:100|unique:coupons,coupon_code",
            "coupon_detail"=>"required|min:5|max:500",
            "coupon_discount"=>"required|regex:/^\d+(\.\d{1,2})?$/",
            "discount_type"=>"required",
            "coupon_type"=>"required",
            "total_uses"=>"digits_between:0,7",
            "start_date"=>"required",
            "end_date"=>"required"
        ],[
            "regex"=>"only digit allowed"
        ]);

        $coupon = new Coupone();
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_details = $request->coupon_detail;
        $coupon->coupon_discount = $request->coupon_discount;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->discount_type = $request->discount_type;
        $coupon->start_date = Carbon::parse($request->start_date)->format(env('APP_DATE_FORMAT'));
        $coupon->end_date = Carbon::parse($request->end_date)->format(env('APP_DATE_FORMAT'));
        if(isset($request->total_uses))
        {
            $coupon->total_uses = $request->total_uses;
        } 
        $coupon->save();

        return redirect()->route('admin.coupon.index')->with('success','Data Inserted Successfully');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupone::where('id',$id)->firstOrFail();
        return view('backend.coupon.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $coupon = Coupone::where('id',$id)->firstOrFail();
        return view('backend.coupon.edit',compact('coupon'));
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
        // dd($id);
         $request->validate([    
            "coupon_code" => "required|min:3|max:100|unique:coupons,coupon_code,".$id,
            "coupon_detail"=>"required|min:5|max:500",
            "coupon_discount"=>"required|regex:/^\d+(\.\d{1,2})?$/",
            "discount_type"=>"required",
            "coupon_type"=>"required",
            "total_uses"=>"digits_between:0,7",
            "start_date"=>"required",
            "end_date"=>"required"
        ],[
            "regex"=>"only digit allowed"
        ]);

        $coupon = Coupone::find($id);
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_details = $request->coupon_detail;
        $coupon->coupon_discount = $request->coupon_discount;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->discount_type = $request->discount_type;
        $coupon->start_date = Carbon::parse($request->start_date)->format(env('APP_DATE_FORMAT'));
        $coupon->end_date = Carbon::parse($request->end_date)->format(env('APP_DATE_FORMAT'));
        if(isset($request->total_uses))
        {
            $coupon->total_uses = $request->total_uses;
        } 
        $coupon->save();

        return redirect()->route('admin.coupon.index')->with('success','Data Updated Successfully');
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
           Coupone::find($id)->delete(); 
        } catch (QueryException $e) {
              return Response()->json(["error"=> 'You cannot delete a Coupon directly , First delete a related records ']);
        }
    }

    public function ajax(Request $request){

        if($request->ajax() && $request->mode =='datatable' )
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
             $totalRecords = Coupone::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Coupone::select('count(*) as allcount')->where('coupon_code', 'like', '%' .$searchValue . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             $records = Coupone::orderBy($columnName,$columnSortOrder)
               ->where('Coupons.coupon_code', 'like', '%' .$searchValue . '%')
               ->select('Coupons.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();
            // dd(DB::getQueryLog());




                // dd($records->toArray()); 
             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
                $id = $record->id;
                $coupon_code = $record->coupon_code;
                $coupon_detail = $record->coupon_detail;
                $coupon_discount = $record->coupon_discount;
                $coupon_type = $record->coupon_type;
                $discount_type = $record->discount_type;
                $start_date = $record->start_date;
                $end_date = $record->end_date;
                $total_uses = $record->total_uses;

                $data_arr[] = array(
                  "id" => $count,
                  "coupon_code" => $coupon_code,
                  "coupon_discount" =>$coupon_discount,
                  "discount_type"=>$discount_type,
                  "coupon_type"=>$coupon_type,
                  "action" => '<a href="'.route('admin.coupon.show',$id).'"> <button type="button" class="btn btn-sm btn-warning" >View </button></a>  <a href="'.route('admin.coupon.edit',$id).'"><button type="button" id="EditBtn" class="btn btn-sm btn-info" >Edit</button></a> <button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button>'
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
