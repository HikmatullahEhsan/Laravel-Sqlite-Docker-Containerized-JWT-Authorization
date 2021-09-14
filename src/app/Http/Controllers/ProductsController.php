<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use Log;
class ProductsController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Get Component Name and Component Description
     *
     * @param Request $request
     * @return Response| json
     */
    public function index()
    {
        $products = Product::all();
        Log::info('Viewed Products');

        return response()->json($products,200);
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

        $product = Product::create([
           'sku'  => $request->sku,
           'name' => $request->name
        ]);
        Log::info('Products Created -'.$product->name);

        return response()->json(['msg'=>'The record has been created!', 'code'=>201],201);
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
        try{
            $product = Product::find($id);
        }catch(Exception $e){
            return response()->json(["msg"=>"Sorry, This record not found", "code"=>404],404);
        }
        return response()->json($product);
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
        $product = Product::find($id)->update([
            'sku' => $request->sku,
            'name' => $request->name
        ]);
        Log::info('Products Updated -'.$product->name);


        return response()->json(['msg'=>'The record has been updated!', 'code'=>200],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where(['product_sku' => $id])->delete();
        Log::info('Products Deleted -'.$id);


        return response()->json(["msg"=>'The record has been deleted', 'code'=>200], 200);
    }

}
