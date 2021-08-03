<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use  App\Models\Page;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.page.create');
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
            "page_name" => 'required',
            "page_text" => 'required'
        ]);



        $page = new Page();
        $page->page_name = $request->page_name;
        $page->page_text = $request->page_text;
        $page->page_status = $request->is_active;
        $page->save();

        return redirect()->route('admin.page.index')->with("success","Data Inserted Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('backend.page.show',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page =  Page::findOrFail($id);

        return view('backend.page.edit',compact('page'));
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

    public function ajax(Request $request)
    {
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
             $totalRecords = Page::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Page::select('count(*) as allcount')->where('page_name', 'like', '%' .$searchValue . '%')->count();

             // DB::enableQueryLog();
             // Fetch records
             $records = Page::orderBy($columnName,$columnSortOrder)
               ->where('Pages.page_name', 'like', '%' .$searchValue . '%')
               ->select('pages.*')
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
                $page_name = $record->page_name;
                $page_status = $record->page_status;

                $action =  '<a href="'.route('admin.page.show',$id).'"> <button type="button" class="btn btn-sm btn-warning" >View </button></a> ';

                if(Auth()->user()->can('Edit Pages'))
                {
                    $action .='<a href="'.route('admin.page.edit',$id).'"><button type="button" id="EditBtn" class="btn btn-sm btn-info" >Edit</button></a> ';
                }

                if(Auth()->user()->can('Delete Pages'))
                {
                    $action .= '<button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> ';
                }

                $data_arr[] = array(
                  "id" => $count,
                  "page_name" =>  $page_name,
                  "page_status"=> $page_status == 0 ? 'Active':'Inactive',
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


    public function  image_upload(Request $request)
    { 
        $onlyImgName = pathinfo($request->file->getClientOriginalName(),PATHINFO_FILENAME);
        $imgExtension = $request->file->getClientOriginalExtension(); 
        $imgName = $onlyImgName."-".time().".".$imgExtension;
        $request->file->move(public_path('backend_asset/pages_images'),$imgName);
        return response()->json(['location'=>"/backend_asset/pages_images/".$imgName ]); 
    }
}
