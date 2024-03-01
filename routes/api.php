<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeItemController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderNoteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttributeItemVariationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
return $request->user();
});*/

Route::middleware('guest')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('forgot-password', [AuthController::class, 'password_request'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'password_email'])->name('password.email');
    Route::post('reset-password', [AuthController::class, 'password_update'])->name('password.update');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function () {
        return responder()->success(auth()->user(), UserTransformer::class)->respond(201);
    });
});

Route::prefix('shop')->group(function () {
    Route::get('products', [ShopController::class, 'products']);
    Route::get('categories', [ShopController::class, 'categories']);
    Route::get('product/{product}', [ControllersProductController::class, 'show']);
    Route::get('attribute-items', [AttributeItemVariationController::class, 'index']);

});

Route::post('create-order', [OrderController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('product')->group(function () {
        Route::patch('{product}/like', [ProductController::class, 'likeToggle']);
    });

    

    Route::prefix('admin')->group(function () {

        Route::prefix('my-orders')->group(function () {
            Route::get('/', [AdminOrderController::class, 'myOrders']);
            Route::get('/{order}', [AdminOrderController::class, 'myOrderView']);
        });

        Route::middleware('role:admin')->group(function () {

            Route::prefix('user')->group(function () {
                Route::get('/', [UserController::class, 'index']);
                Route::post('/', [UserController::class, 'store']);
                Route::get('/{user}', [UserController::class, 'edit']);
                Route::put('/{user}', [UserController::class, 'update']);
                Route::delete('/{user}', [UserController::class, 'destroy']);
            });

            Route::prefix('product')->group(function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::post('/', [ProductController::class, 'store']);
                Route::get('/{product}', [ProductController::class, 'edit']);
                Route::put('/{product}', [ProductController::class, 'update']);
                Route::delete('/{product}', [ProductController::class, 'destroy']);
            });
            Route::post('/variations/{product}', [ProductController::class, 'variations']);
            Route::prefix('category')->group(function () {
                Route::get('/', [CategoryController::class, 'index']);
                Route::post('/', [CategoryController::class, 'store']);
                Route::get('/{category}', [CategoryController::class, 'edit']);
                Route::put('/{category}', [CategoryController::class, 'update']);
                Route::delete('/{category}', [CategoryController::class, 'destroy']);
            });
            Route::prefix('attribute')->group(function () {
                Route::get('/', [AttributeController::class, 'index']);
                Route::post('/', [AttributeController::class, 'store']);
                Route::get('/{attribute}', [AttributeController::class, 'edit']);
                Route::put('/{attribute}', [AttributeController::class, 'update']);
                Route::delete('/{attribute}', [AttributeController::class, 'destroy']);

            });

            Route::prefix('attribute-item')->group(function () {
                Route::get('/{attributeId}', [AttributeItemController::class, 'index']);
                Route::post('/', [AttributeItemController::class, 'store']);
                Route::get('edit/{attributeItem}', [AttributeItemController::class, 'edit']);
                Route::put('/{attributeItem}', [AttributeItemController::class, 'update']);
                Route::delete('/{attributeItem}', [AttributeItemController::class, 'destroy']);
            });

            Route::prefix('variation')->group(function () {
                //Route::get('/possibilities', [VariationController::class, 'possibilities']);
                Route::post('/', [VariationController::class, 'store']);

            });

            Route::prefix('order')->group(function () {
                Route::get('/', [AdminOrderController::class, 'index']);
                Route::get('{order}/notes', [AdminOrderController::class, 'getNotes']);
                Route::post('/', [ProductController::class, 'store']);
                Route::get('/{order}', [AdminOrderController::class, 'edit']);
                Route::put('/{order}', [AdminOrderController::class, 'update']);
                Route::delete('/{order}', [ProductController::class, 'destroy']);
            });

            Route::prefix('note')->group(function () {
                Route::get('/', [AdminOrderController::class, 'index']);
                Route::post('/', [OrderNoteController::class, 'store']);
                Route::get('/{order}', [OrderNoteController::class, 'orderNotes']);
                Route::put('/{order}', [AdminOrderController::class, 'update']);
                Route::delete('/{note}', [OrderNoteController::class, 'destroy']);
            });
        });



    });

});
