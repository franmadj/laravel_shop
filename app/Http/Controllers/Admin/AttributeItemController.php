<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeItemRequest;
use App\Http\Requests\UpdateAttributeItemRequest;
use App\Models\AttributeItem;
use App\Transformers\AttributeItemTransformer;
use Illuminate\Http\JsonResponse;

class AttributeItemController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($attributeId):JsonResponse
    {
        try {
            return responder()->success(AttributeItem::where('attribute_id', $attributeId), AttributeItemTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttributeItemRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttributeItemRequest $request):JsonResponse
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
     * Return data for editing the specified resource.
     *
     * @param  \App\Models\AttributeItem  $attributeItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(AttributeItem $attributeItem):JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAttributeItemRequest $request, AttributeItem $attributeItem):JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AttributeItem $attributeItem):JsonResponse
    {
        try {
            $attributeItem->delete();
            return responder()->success()->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
