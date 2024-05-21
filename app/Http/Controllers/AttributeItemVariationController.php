<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttributeItemVariation;
use Illuminate\Http\JsonResponse;

class AttributeItemVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
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
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }

    }

}
