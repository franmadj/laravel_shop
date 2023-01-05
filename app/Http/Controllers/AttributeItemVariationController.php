<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeItemProductRequest;
use App\Models\AttributeItemVariation;

class AttributeItemVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attr = request('attr', false);
        $product = request('product', false);

        //dd($attr,$product, request('variations', false));
        if ($attr && $product) {
            $items = AttributeItemVariation::where('attribute_id', $attr)->where('product_id', $product);
            if ($variations = request('variations', false)) {
                $items = $items->whereIn('variation_id', $variations);
            }
            return responder()->success($items->get())->respond(200);

        }
        return responder()->error()->respond();

        
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

}
