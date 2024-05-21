<?php

namespace App\Http\Controllers\Admin;

use App\Models\ItemOrder;
use App\Http\Requests\StoreItemOrderRequest;
use App\Http\Requests\UpdateItemOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ItemOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreItemOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemOrder  $itemOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ItemOrder $itemOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemOrder  $itemOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemOrder $itemOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemOrderRequest  $request
     * @param  \App\Models\ItemOrder  $itemOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemOrderRequest $request, ItemOrder $itemOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemOrder  $itemOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemOrder $itemOrder)
    {
        //
    }
}
