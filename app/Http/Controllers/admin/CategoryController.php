<?php 

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

use App\Models\Category;

use Validator;


class CategoryController extends Controller
{

    //Constructer for specifying a middleware of roles and permission
    public function __construct()
    {
        $this->middleware('permission:View Categories',['only'=>['index']]);
    }

    /**
     * Show all Category Data
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categorys = Category::where('parent_category_id',Null)->get();
        return view('backend.category.index',compact('Categorys'));
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
     * Category Insert Logic
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $AddCategoryValidator = Validator::make($request->all(),[
            'category_name' => 'required|min:3|max:100|regex:/^[\pL\s]+$/u|unique:categorys,category_name'
        ],
        [
            'regex'=>"Category name allow only alphabet,space" 
        ]);

        if($AddCategoryValidator->fails())
        {
            return Response()->json(["error"=> $AddCategoryValidator->errors()->all() ]);
        }

        $categorydata = new Category();
        $categorydata->category_name = $request->category_name;
        $categorydata->parent_category_id  = $request->Category;
        $categorydata->save();

        if($categorydata->parent_category_id == Null)
        {
            return Response()->json(["success"=> "data inserted successfully" , 'text' =>$categorydata->category_name ,'id'=>$categorydata->id ]);
        }
        else
        {
             return Response()->json(["success"=> "data inserted successfully"]);
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
     * Uodate a Category
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $EditCategoryValidator = Validator::make($request->all(),[
            'category_name' => 'required|min:3|max:100|regex:/^[\pL\s]+$/u|unique:categorys,category_name,'.$id
        ]);

        if($EditCategoryValidator->fails())
        {
            return Response()->json(["error"=>$EditCategoryValidator->errors()->all()]);
        }
        $category_data = Category::where('id','=',$id)->first();
        $category_data->category_name = $request->category_name;
        $category_data->parent_category_id = $request->edit_category;
        $category_data->save();

        return Response()->json(["success"=> "Data updated Successfully" ]);
    }

    /**
     * 
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Category::where('id','=',$id)->delete();
            return Response()->json(['id'=>$id,'success' => 'Record Deleted Successfully']);
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Category directly , First delete a related records ']);
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
             $totalRecords = Category::select('count(*) as allcount')->count();
             $totalRecordswithFilter = Category::select('count(*) as allcount')->where('category_name', 'like', '%' .$searchValue . '%')->count();

             // Fetch records
             $records = Category::with('Parent_Category')->orderBy($columnName,$columnSortOrder)
               ->where('Categorys.category_name', 'like', '%' .$searchValue . '%')
               ->select('Categorys.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();

               // dd($records);

             $data_arr = array();

             //for a counter 
             $count = 1;

             foreach($records as $record){
                $id = $record->id;
                $name = $record->category_name;
                $parent_category = isset($record->Parent_Category->category_name)?$record->parent_category->category_name:'-';
                $action ="";

                if(Auth()->user()->can('Edit Categories'))
                {
                    $action .= '<button type="button" id="EditBtn" editurl="'.route('admin.category.update',$id).'"           editdata="'.htmlspecialchars($record,ENT_QUOTES,'UTF-8').'"  class="btn btn-sm btn-info" >Edit</button> ';
                }

                if(Auth()->user()->can('Delete Categories'))
                {
                    $action .= '<button type="button" id="delbtn" onClick="DeleteFunc('.$id.')"   class="btn btn-danger btn-sm" >Delete</button> ';
                }


                $data_arr[] = array(
                  "id" => $count,
                  "category_name" => $name,
                  "Parent_Category_Name" => $parent_category, 
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
