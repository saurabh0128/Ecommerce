<?php
 
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RatingReview;

use DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.rating.index');
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
        //
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
        //
    }

    public function ajax(Request $request){

        if($request->ajax()|| $request->mode == 'datatable')
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
             $GLOBALS['searchValue'] = $search_arr['value']; // Search value

             // Total records
             $totalRecords = RatingReview::select('count(*) as allcount')->count();
             $totalRecordswithFilter = RatingReview::select('count(*) as allcount')->where('review', 'like', '%' .$GLOBALS['searchValue'] . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             //Group by Query for avrage rating of every product
             $records = RatingReview::with(array('product'=>function($query){
                    $query->where('product_name','like','%'.$GLOBALS['searchValue'].'%');
                }))->orderBy($columnName,$columnSortOrder)
               // ->where('rating_reviews.review', 'like', '%' .$searchValue . '%')
               ->select('product_id',DB::raw('AVG(rating_reviews.rating) as avrage_rating '))
               ->groupBy('product_id')
               ->skip($start)
               ->take($rowperpage)
               ->get();
             // dd(DB::getQueryLog());




                 // dd($records->toArray()); 
             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
                
                if($record->product != null)
                {
                    $id = $record->id;
                    $avrage_rating  = $record->avrage_rating;
                    $product_name = $record->product->product_name;
                    $product_img = $record->product->product_img;
                    $data_arr[] = array(
                      "id" => $count,
                      "avrage rating" => '<div class="product_rating" data-rating="'.$avrage_rating.'" > </div>',
                      "product name" =>$product_name,
                      "product image"=> '<img src="'.asset('/backend_asset/product_images/'.$product_img).'" alt="product image" height="100" width="100" >'
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
