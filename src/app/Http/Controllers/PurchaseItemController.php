<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Log;
use App\PurchasedItem;
class PurchaseItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userId= Auth::user()->id;
        $items = PurchasedItem::where('user_id', $userId)->get();
        Log::info('Viewed User related Products');
        return response()->json($items);
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
        $purchase = PurchasedItem::create([
            'user_id'     => Auth::user()->id,
            'product_sku' => $request->product_sku
        ]);
        Log::info('Product Purchase Created -'.$purchase->product_sku);
        return response()->json(['msg'=>'The record has been created!', 'code'=>201],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $product = PurchasedItem::where(['user_id'=> Auth::user()->id])->get();
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
        //
        $purchase = PurchasedItem::where([
            'product_sku' => $id,
            'user_id'     => Auth::user()->id
            ])->update(['product_sku' => $request->product_sku]);

        Log::info('Product Purchase Updated -'.$purchase->product_sku);
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
        $purchase = PurchasedItem::where([
            'product_sku' => $id,
            'user_id'     => Auth::user()->id
            ])->delete();

        Log::info('Product Purchase Deleted -'.$id);
        return response()->json(["msg"=>'The record has been deleted', 'code'=>200], 200);
    }
}
