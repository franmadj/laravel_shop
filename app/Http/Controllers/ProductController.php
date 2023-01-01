<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    { 
        return responder()->success($product, ProductTransformer::class)->respond(200);
    }

    
}
