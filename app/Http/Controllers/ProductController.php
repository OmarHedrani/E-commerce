<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib3\File\ASN1\Maps\Name;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        $response['data']=$products;
        $response['message']="This is all products";
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

      $product=Product::query()->create([
          'name'=>$request->name,
           'price'=>$request->price,
          'description'=>$request->description,
          'exp_data'=>$request->exp_data,
          'img_url'=>$request->img_urll,
          'quantity'=>$request->quantity,
          'category_id'=>$request->category_id,
          'user_id'=>Auth::id(),
          ]);



        /////discount

foreach ($request->list_discounts as $discount){
     $product->discounts()->create([
        'date'=>$discount['date'],
        'discount_percentage'=>$discount['discount_percentage'],
    ]);

}
   ///////////end discount



        $response['data']=$product;
        $response['message']="Product Created Successfully";
        $response['status_code']=200;
        return response()->json($response,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);

        if(isset($product)){
         ///////////////////

            $discounts=$product->discounts()->get();
            $maxDiscount=null;
            foreach ($discounts as $discount){
               if(Carbon::parse($discount['date'])<=now()){
                   $maxDiscount=$discount;
               }}
            if(!is_null($maxDiscount)){
                $discount_value=($product->price*$maxDiscount['discount_percentage'])/100;
                $product['current_price']=$product->price-$discount_value;}

            //////
         $product->increment('views');
            $response['data']=$product;
            $response['message']="Success";
            $response['status_code']=200;
            return response()->json($response ,200);
        }
        $response['data']=$product;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);

    }

    public function search_products(Request $request)
    {   $name=$request->query('name');
        $price_from=$request->query('price_from');
        $price_to=$request->query('price_to');
        $category_id=$request->query('category_id');
        $exp_data=$request->query('exp_data');
        $productQuery=Product::query();

        if( isset($name))
        {$productQuery->where('name',"=",$name);};
        if( isset($exp_data))
        {$productQuery->where('exp_data',"=",$exp_data);};
        if($category_id)
        {$productQuery->where('category_id','=',$category_id);};
        if($price_from)
        {$productQuery->where('price','>=',$price_from);};
        if($price_to)
        {$productQuery->where('price',"<=",$price_to);};
        $product=$productQuery->get();


        if(isset($product)){
            $response['data']=$product;
            $response['message']="Success";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']=$product;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product=Product::find($id);
        if(isset($product)){

            if (isset($request->name)){
                $product->name = $request->name;}
            if (isset($request->price)){
                $product->price = $request->price;}
            if (isset($request->description)){
                $product->description = $request->description;}

            if (isset($request->img_url)){
                $product->img_url = $request->img_url;}
            if (isset($request->quantity)){
                $product->quantity = $request->quantity;}
            if (isset($request->category_id)){
                $product->category_id = $request->category_id;}

            $product->save();
            $response['data']=$product;
            $response['message']="Updated Successfully";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']=$product;
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        if(isset( $product)){
            $product->delete();
            $response['data']=$product;
            $response['message']="Product Deleted Successfully";
            $response['status_code']=200;
            return response()->json($response,200);
        }
        $response['data']='';
        $response['message']="Error not found";
        $response['status_code']=404;
        return response()->json($response,404);
    }
}
