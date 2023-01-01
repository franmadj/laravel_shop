<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeItemVariation;
use App\Http\Requests\StoreAttributeItemProductRequest;
use App\Http\Requests\UpdateAttributeItemProductRequest;
use App\Http\Controllers\Controller;

class AttributeItemVariationController extends Controller
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
     * @param  \App\Http\Requests\StoreAttributeItemProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeItemProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributeItemProduct  $attributeItemProduct
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeItemProduct $attributeItemProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeItemProduct  $attributeItemProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributeItemProduct $attributeItemProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttributeItemProductRequest  $request
     * @param  \App\Models\AttributeItemProduct  $attributeItemProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeItemProductRequest $request, AttributeItemProduct $attributeItemProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeItemProduct  $attributeItemProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeItemProduct $attributeItemProduct)
    {
        //
    }
}
