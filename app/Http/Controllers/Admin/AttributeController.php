<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Transformers\AttributeTransformer;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{

    /**
     * return a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAttributeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttributeRequest $request):JsonResponse
    {
        try {
            $validated = $request->validated();
            if (Attribute::create($validated)) {
                return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * return data for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Attribute $attribute):JsonResponse
    {
        try {
            return responder()->success($attribute, AttributeTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttributeRequest  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute):JsonResponse
    {
        try {
            $validated = $request->validated();
            if ($attribute->update($validated)) {

                return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attribute $attribute):JsonResponse
    {
        try {
            $attribute->delete();
            return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
