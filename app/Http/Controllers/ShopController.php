<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Transformers\ProductTransformer;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
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
    }

    public function categories()
    {
        return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
    }

    
}
