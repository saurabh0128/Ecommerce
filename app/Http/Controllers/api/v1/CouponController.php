<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupone;
use Carbon\carbon;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon = Coupone::all();

        return Response()->json($coupon);
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

        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }else{
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

            return Response()->json(['success'=>'Data Inserted Successfully']); 
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
        $validator = Validator::make($request->all(),[       
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

        if($validator->fails())
        {
            return Response()->json(["error"=>$validator->errors()->all()]);
        }else{
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

            return Response()->json(['success'=>'Data Updated Successfully']);
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
        try {
            Coupone::where('id',$id)->delete();
            return Response()->json(["success"=> 'Data Deleted Successfully']); 
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Coupon directly , First delete a related records ']);
        }
    }
}
