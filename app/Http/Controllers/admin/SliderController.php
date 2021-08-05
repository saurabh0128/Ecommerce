<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\carbon;
use Image;

use Illuminate\Database\QueryException;

class SliderController extends Controller
{


     //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Slider',['only'=>['index']]);
        $this->middleware('permission:Add Slider' , ['only'=>['create']]);
        $this->middleware('permission:Edit Slider',['only'=>['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.slider.create');
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
            "slide_image"  => 'required|image',
            'slide_status' => 'required',
            'slide_url'   => 'required',
            'start_date'   => 'required',
            'end_date'     => 'required', 
            'slide_text'   => 'required'
        ]);

        $slide = new Slider();
        $slide->slide_status = $request->slide_status;
        $slide->slide_text = $request->slide_text;
        $slide->slide_link = $request->slide_url;
        $slide->start_date =  Carbon::parse($request->start_date)->format(env('APP_DATE_FORMAT'));
        $slide->end_date = Carbon::parse($request->end_date)->format(env('APP_DATE_FORMAT'));

        $onlyImgName = pathinfo($request->slide_image->getClientOriginalName(),PATHINFO_FILENAME);
        $imgExtension = $request->slide_image->getClientOriginalExtension(); 
        $imgName = $onlyImgName."-".time().".".$imgExtension;
        $request->slide_image->move(public_path('backend_asset/slide_images'),$imgName);
        $slide->slide_image = $imgName;
        $slide->save();

        $img = Image::make(public_path('backend_asset/slide_images/'.$imgName));
        $img->resize(150,150);
        $img->save(public_path().'/backend_asset/thumbnail/slide_images/'.$imgName);

        return redirect()->route('admin.slide.index')->with('success','Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.show',compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit',compact('slider'));
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
        $request->validate([
            "slide_image"  => 'image',
            'slide_status' => 'required',
            'slide_url'   => 'required',
            'start_date'   => 'required',
            'end_date'     => 'required', 
            'slide_text'   => 'required'
        ]);


        $slider = Slider::find($id);

        if($request->hasFile('slide_image'))
        {
            $onlyImgName = pathinfo($request->slide_image->getClientOriginalName(),PATHINFO_FILENAME);
            $imgExtension = $request->slide_image->getClientOriginalExtension(); 
            $imgName = $onlyImgName."-".time().".".$imgExtension;
            $request->slide_image->move(public_path('backend_asset/slide_images'),$imgName);

            $img = Image::make(public_path('backend_asset/slide_images/'.$imgName));
            $img->resize(150,150);
            $img->save(public_path().'/backend_asset/thumbnail/slide_images/'.$imgName);

            $slider->slide_image = $imgName ;
        }

        $slider->slide_text = $request->slide_text;
        $slider->slide_status = $request->slide_status;
        $slider->slide_link = $request->slide_url; 
        $slider->start_date = Carbon::parse($request->start_date)->format(env('APP_DATE_FORMAT'));
        $slider->end_date   = Carbon::parse($request->end_date)->format(env('APP_DATE_FORMAT')); 
        $slider->save();

        return redirect()->route('admin.slide.index')->with('success','Data Updated Successfully');
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
            Slider::where('id','=',$id)->delete();
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Page directly , First delete a related records ']);
        }
    }

    public function ajax(Request $request){
        if($request->ajax() || $request->data == 'datatable')
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
             $totalRecords = Slider::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Slider::select('count(*) as allcount')->where('slide_text', 'like', '%' .$searchValue . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             $records = Slider::orderBy($columnName,$columnSortOrder)
               ->where('Sliders.slide_text', 'like', '%' .$searchValue . '%')
               ->select('Sliders.*')
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
                $slide_image  = $record->slide_image;
                $slide_status = $record->slide_status;
                $slide_link   = $record->slide_link;
                $start_date   = $record->start_date;
                $end_date     = $record->end_date;

                $action =  '<a href="'.route('admin.slide.show',$id).'"> <button type="button" class="btn btn-sm btn-warning" >View </button></a> ';

                if(Auth()->user()->can('Edit Slider'))
                {
                    $action .='<a href="'.route('admin.slide.edit',$id).'"><button type="button" id="EditBtn" class="btn btn-sm btn-info" >Edit</button></a> ';
                }

                if(Auth()->user()->can('Delete Slider'))
                {
                    $action .= '<button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> ';
                }

                $data_arr[] = array(
                  "id" => $count,
                  "slide_image" =>  '<img src="'.asset_img($slide_image,'thumbnail/slide_images').'" alt="slide image" height="100" width="100" >' ,
                  "slide_status"=> $slide_status == 0 ? 'Active':'Inactive',
                  "start_date" => $start_date,
                  "end_date" => $end_date,
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
