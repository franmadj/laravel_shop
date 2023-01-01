<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeItem;
use App\Http\Requests\StoreAttributeItemRequest;
use App\Http\Requests\UpdateAttributeItemRequest;
use App\Transformers\AttributeItemTransformer;
use App\Http\Controllers\Controller;

class AttributeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attributeId)
    {
        return responder()->success(AttributeItem::where('attribute_id',$attributeId), AttributeItemTransformer::class)->respond(201);
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
     * @param  \App\Http\Requests\StoreAttributeItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeItemRequest $request)
    {
        $validated = $request->validated();
        if (AttributeItem::create($validated)) {
            return responder()->success()->respond(201);
        }
        return responder()->error()->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeItem $attributeItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributeItem $attributeItem)
    {
        return responder()->success($attributeItem, AttributeItemTransformer::class)->respond(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttributeItemRequest  $request
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeItemRequest $request, AttributeItem $attributeItem)
    {
        $validated = $request->validated();
        if ($attributeItem->update($validated)) {
            
            return responder()->success()->respond(201);
        }
        return responder()->error()->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeItem $attributeItem)
    {
        $attributeItem->delete();
        return responder()->success()->respond(201);
    }
}
