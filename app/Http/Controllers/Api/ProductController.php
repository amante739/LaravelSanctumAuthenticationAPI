<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products=Product::all();
        return response()->json([
            'status'=>true,
            'message'=>"All Products",
            'data'=>$products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //no use
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
        $validateData=Validator::make($request->all(),[
            'name'=>"required",
            'price'=>"required",
            'quantity'=>"required"
        ]);

        if($validateData->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Invalid Request",
                'error'=>$validateData->error()
            ]);

        }
        $product=Product::Create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>"Product created successfully.",
            'data'=>$product
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        if(is_null($product)){
            return response()->json([
                'status'=>false,
                'message'=>'Product Not found'
            ]);
        }
        return response()->json([
            'status'=>true,
            'message'=>'Product found',
            'data'=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //no use
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validateData=Validator::make($request->all(),[
            'name'=>"required",
            'price'=>"required",
            'quantity'=>"required"
        ]);

        if($validateData->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Invalid Request",
                'error'=>$validateData->error()
            ]);

        }

        $product->name=$request['name'];
        $product->price=$request['price'];
        $product->quantity=$request['quantity'];
        $product->save();
        return response()->json([
            'status'=>true,
            'message'=>'Product Updated Successfully',
            'data'=>$product
        ]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Product Deleted Successfully',
            'data'=>$product
        ]);

    }
}
