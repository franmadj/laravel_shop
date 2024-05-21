<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    /**
     * returns the specified resource in shop page.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product):JsonResponse
    {
        try {
            return responder()->success($product, ProductTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

}
