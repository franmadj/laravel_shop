<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Transformers\CategoryTransformer;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
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
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return responder()->success($category, CategoryTransformer::class)->respond(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        if ($category->update($validated)) {
            $file = request()->file('file');
            if (isset($file) && !empty($file) && $file->isValid()) {
                $category->clearMediaCollection()
                    ->addMedia($file)
                    ->usingName('image')
                    ->toMediaCollection();
            }elseif (request('clearFiles')) {
                $category->clearMediaCollection();
            }
            return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
        }
        return responder()->error()->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return responder()->success(Category::all(), CategoryTransformer::class)->respond(201);
    }
}
