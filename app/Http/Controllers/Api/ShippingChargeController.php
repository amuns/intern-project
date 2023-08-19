<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Api\ShippingCharge;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingChargeResource;

class ShippingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ShippingCharge::where('title', 'delivery_charge')->get();
        return ShippingChargeResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['title'] = "delivery_charge";
        $data['amount'] = $request->delivery_charge;

        $shippingCharge = ShippingCharge::create($data);

        return new ShippingChargeResource($shippingCharge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $data['amount'] = intval($request->delivery_charge);
        
        DB::table('shipping_charges')->where('id', $request->id)->update($data);
        $shippingCharge = ShippingCharge::first();
        return new ShippingChargeResource($shippingCharge);
    }

}
