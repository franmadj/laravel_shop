<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    /**
     * Toggle user post like
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeToggle(Product $product, Request $request):JsonResponse
    {
        try {
            // $with = ['postable.user', 'likes'];
            $product = $product->like(auth()->user()->id);
            return responder()->success($product, new ProductTransformer())->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            $products = new Product;
            if ($search = request('search', '')) {
                $products = $products->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
                });
            }
            if ($status = request('status', '')) {
                $products = $products->where('status', $status);
            }
            if ($type = request('type', '')) {
                $products = $products->where('type', $type);
            }
            if ($category = request('category', '')) {
                $products = $products->whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category);

                });
            }

            return responder()->success($products->get(), ProductTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request):JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['in_stock'] = $request->stock_status == 'in_stock';
            if ($product = Product::create($validated)) {
                $files = request('files', []);
                if (!empty($files) && is_array($files)) {
                    foreach ($files as $file) {
                        if (isset($file) && !empty($file) && $file->isValid()) {
                            $product
                                ->addMedia($file)
                                ->usingName('image')
                                ->toMediaCollection();
                        }

                    }
                }

                $gallery = request('gallery', []);
                if (!empty($gallery) && is_array($gallery)) {
                    $product->clearMediaCollection('gallery');
                    foreach ($gallery as $image) {
                        if (isset($image) && !empty($image) && $image->isValid()) {
                            $product
                                ->addMedia($image)
                                ->usingName('gallery_image')
                                ->toMediaCollection('gallery');
                        }

                    }
                }

                if ($request->has('categories') and is_array($request->categories)) {
                    $product->categories()->attach(collect($request->categories));
                }
                return responder()->success(['id' => $product->id])->respond(201);
            }
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Product  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function variations(Product $product):JsonResponse
    {
        //dd(request()->all());
        try {
            $variations = request('variations', '');

            $prodVariations = json_decode($product->variations);

            if (
                $prodVariations &&
                !empty($variations['attrs']) &&
                is_array($variations['attrs']) &&
                !empty($prodVariations->attrs) &&
                is_array($prodVariations->attrs)) {

                if (
                    count($variations['attrs']) != count($prodVariations->attrs) ||
                    count(array_intersect($variations['attrs'], $prodVariations->attrs)) != count($prodVariations->attrs)) {
                    $product->variations()->delete();

                }
            }

            if (!empty($variations['possibilities']) && is_array($variations['possibilities'])) {

                foreach ($variations['possibilities'] as &$variation) {

                    //$data=array_only($variation['data'],)
                    if (!empty($variation['data']['stock_status'])) {
                        $variation['data']['in_stock'] = $variation['data']['stock_status'] == 'in_stock';
                    }

                    if (empty($variation['data']['price'])) {
                        $variation['data']['price'] = $product->price;
                    } else {
                        $variation['data']['price'] = floatval($variation['data']['price']);
                    }
                    if (!empty($variation['data']['sale_price'])) {
                        $variation['data']['sale_price'] = floatval($variation['data']['sale_price']);
                    }

                    $variation['open'] = false;

                    if (empty($variation['id'])) {
                        if ($variation['added'] && !empty($variation['items']) && is_array($variation['items']) && !empty($variation['items'][0]['id'])) {

                            $newVariation = $product->variations()->create(Arr::except($variation['data'], ['stock_status']));
                            $variation['id'] = $newVariation->id;
                            //$attrItems = collect($variation['items'])->pluck('id');
                            collect($variation['items'])->each(function ($item) use ($newVariation, $product) {
                                $newVariation->AttributeItems()->attach($item['id'], ['product_id' => $product->id, 'attribute_id' => $item['attributeId']]);

                            });

                        }

                    } elseif (!empty($variation['updated']) && 'save' == $variation['action']) {

                        $product->variations()->where('id', $variation['id'])->update(Arr::except($variation['data'], ['stock_status']));
                        $variation['updated'] = false;
                        $variation['action'] = 'none';

                    } elseif (!empty($variation['updated']) && 'remove' == $variation['action']) {
                        $product->variations()->where('id', $variation['id'])->delete();
                        $variation['updated'] = false;
                        $variation['action'] = 'none';
                    }

                }
                //$update=$product->update(['variations' => json_encode($variations)]);
                $product->variations = json_encode($variations);
                $update = $product->save();

            }

            return responder()->success($variations)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }

    }


    /**
     * Returns data for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Product $product):JsonResponse
    {
        try {
            return responder()->success($product, ProductTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product):JsonResponse
    {
        try {
            $validated = $request->validated();
            if ($product->update($validated)) {

                $files = request('files', []);
                if (!empty($files) && is_array($files)) {
                    $product->clearMediaCollection();
                    foreach ($files as $file) {
                        if (isset($file) && !empty($file) && $file->isValid()) {
                            $product
                                ->addMedia($file)
                                ->usingName('image')
                                ->toMediaCollection();
                        }

                    }
                } elseif (request('clearFiles')) {
                    $product->clearMediaCollection();
                }

                $gallery = request('gallery', []);
                if (!empty($gallery) && is_array($gallery)) {
                    $product->clearMediaCollection('gallery');
                    foreach ($gallery as $image) {
                        if (isset($image) && !empty($image) && $image->isValid()) {
                            $product
                                ->addMedia($image)
                                ->usingName('gallery_image')
                                ->toMediaCollection('gallery');
                        }

                    }
                } elseif (request('clearGallery')) {
                    $product->clearMediaCollection('gallery');
                }

                if ($request->has('categories') and is_array($request->categories)) {
                    $product->categories()->detach();
                    $product->categories()->attach(collect($request->categories));
                }
                return responder()->success()->respond(200);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product):JsonResponse
    {
        $product->delete();
        return responder()->success(Product::all(), ProductTransformer::class)->respond(200);
    }
}
