<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories=Category::all();
      $response['data']=$categories;
      $response['message']="This is all categories";
        $response['status_code']=200;
      return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category=new Category;
        $category->name = $request->name;
        $category->save();

        $response['data']=$category;
        $response['message']="Category Created Successfully";
        $response['status_code']=200;
        return response()->json($response,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     $category=Category::find($id);
     if(isset( $category)){
         $response['data']=$category;
         $response['message']="Success";
         $response['status_code']=200;
         return response()->json($response,200);
     }
        $response['data']=$category;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);

    }
    public function show_name(Request $request)
    {
        $name=$request->query('name');
        $categoryQuery=Category::query();
        $categoryQuery->where('name',"=",$name);
        $category=$categoryQuery->get();

        if(isset( $category)){
            $response['data']=$category;
            $response['message']="Success";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']=$category;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $category=Category::find($id);
        if(isset( $category)){
            if (isset($request->name)){
            $category->name = $request->name;}
            $category->save();
            $response['data']=$category;
            $response['message']="Updated Successfully";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']=$category;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $categoryz
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::find($id);
        if(isset( $category)){
            $category->delete();
            $response['data']=$category;
            $response['message']="Category Deleted Successfully";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']='';
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);
    }
}
