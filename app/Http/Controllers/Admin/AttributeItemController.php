<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeItemRequest;
use App\Http\Requests\UpdateAttributeItemRequest;
use App\Models\AttributeItem;
use App\Transformers\AttributeItemTransformer;

class AttributeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attributeId)
    {
        try {
            return responder()->success(AttributeItem::where('attribute_id', $attributeId), AttributeItemTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
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
        try {
            $validated = $request->validated();
            if (AttributeItem::create($validated)) {
                return responder()->success()->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
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
        try {
            return responder()->success($attributeItem, AttributeItemTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
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
        try {
            $validated = $request->validated();
            if ($attributeItem->update($validated)) {

                return responder()->success()->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributeItem $attributeItem)
    {
        try {
            $attributeItem->delete();
            return responder()->success()->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
