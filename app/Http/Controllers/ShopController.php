<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Transformers\CategoryTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;

class ShopController extends Controller
{
    /**
     * Returns a listing of the products in shop page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function products():JsonResponse
    {
        try {
            $products = new Product;
            if ($search = request('search', '')) {
                $products = $products->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
                });
                //$products=$products->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
            }

            if ($category = request('category', '')) {
                $products = $products->whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category);

                });
            }

            //dd($products->toSql());

            return responder()->success($products->get(), ProductTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Returns a listing of the categories in shop page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories():JsonResponse
    {
        try {
            return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

}
