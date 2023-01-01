<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Transformers\AttributeTransformer;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
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
     * @param  \App\Http\Requests\StoreAttributeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $request)
    {
        $validated = $request->validated();
        if (Attribute::create($validated)) {
            return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
        }
        return responder()->error()->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return responder()->success($attribute, AttributeTransformer::class)->respond(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttributeRequest  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $validated = $request->validated();
        if ($attribute->update($validated)) {
            
            return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
        }
        return responder()->error()->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return responder()->success(Attribute::all(), AttributeTransformer::class)->respond(201);
    }
}
