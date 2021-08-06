<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\carbon;
use Validator;
use Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = Slider::all();

        return Response()->json($slider);
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
            "slide_image"  => 'required|image',
            'slide_status' => 'required',
            'slide_url'   => 'required',
            'start_date'   => 'required',
            'end_date'     => 'required', 
            'slide_text'   => 'required'
        ]);

        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all()]);
        }else{

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
            "slide_image"  => 'image',
            'slide_status' => 'required',
            'slide_url'   => 'required',
            'start_date'   => 'required',
            'end_date'     => 'required', 
            'slide_text'   => 'required'
        ]);

        if($Validator->fails())
        {
            return Response()->json(["error"=>$Validator->errors()->all()]);
        }else{

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

            return Response()->json(["success"=>"Data Updated Successfully"]);
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
            Slider::where('id','=',$id)->delete();
            return Response()->json(['success'=>'Data Deleted Successfully']);
        } catch (QueryException $e) {
            return Response()->json(["error"=> 'You cannot delete a Page directly , First delete a related records ']);
        }
    }
}
