<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request):JsonResponse
    {
        try {
            $validated = $request->validated();
            if ($category = Category::create($validated)) {
                $file = request()->file('file');
                if (isset($file) && !empty($file) && $file->isValid()) {
                    $category->addMedia($file)
                        ->usingName('image')
                        ->toMediaCollection();
                }
                return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Return data for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Category $category):JsonResponse
    {
        try {
            return responder()->success($category, CategoryTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category):JsonResponse
    {
        try {
            $validated = $request->validated();
            if ($category->update($validated)) {
                $file = request()->file('file');
                if (isset($file) && !empty($file) && $file->isValid()) {
                    $category->clearMediaCollection()
                        ->addMedia($file)
                        ->usingName('image')
                        ->toMediaCollection();
                } elseif (request('clearFiles')) {
                    $category->clearMediaCollection();
                }
                return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
            }
            return responder()->error()->respond();
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category):JsonResponse
    {
        try {
            $category->delete();
            return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
