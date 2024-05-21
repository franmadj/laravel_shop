<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Transformers\OrderNoteTransformer;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * Returns order for admin analytics data for dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminStatistics():JsonResponse
    {
        try {
            $ordersCount = Order::all();
            $newOrdersCount = $ordersCount->filter(
                fn($order) => $order->whereId($order->id)->where('created_at', '>', Carbon::now()->subWeek())->count()
            );
            $data = [
                'ordersCount' => $ordersCount->count(),
                'newOrdersCount' => $newOrdersCount->count(),
            ];
            return responder()->success($data)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();

        }
    }

    /**
     * Returns order for no admin analytics data for dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminMyOrderStatistics():JsonResponse
    {
        try {
            $ordersCount = Auth()->user()->orders;
            $data = [
                'ordersCount' => $ordersCount->count(),
            ];
            return responder()->success($data)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();

        }
    }

    /**
     * returns a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        try {
            $orders = Order::all();
            if ($search = request('search', '')) {
                $orders = $orders->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
                });
            }
            if ($status = request('status', '')) {
                $orders = $orders->where('status', $status);
            }
            if ($dateRange = request('dateRange', '')) {
                if (!empty($dateRange[0]) && !empty($dateRange[1])) {
                    $fromDate = (new Carbon($dateRange[0]))->format('Y-m-d H:i:s');
                    $toDate = (new Carbon($dateRange[1]))->format('Y-m-d H:i:s');
                }
                $orders = $orders->whereBetween('created_at', [$fromDate, $toDate]);
            }
            return responder()->success($orders, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine())->respond();
        }
    }

    /**
     * returns a listing of the resource for a logged in user .
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrders():JsonResponse
    {
        try {
            $orders = Auth()->user()->orders;
            if ($search = request('search', '')) {
                $orders = $orders->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
                });
                //$products=$products->where('title', 'like', "%$search%")->orWhere('content', 'like', "%$search%");
            }
            if ($status = request('status', '')) {
                $orders = $orders->where('status', $status);
            }
            if ($dateRange = request('dateRange', '')) {
                if (!empty($dateRange[0]) && !empty($dateRange[1])) {
                    $fromDate = (new Carbon($dateRange[0]))->format('Y-m-d H:i:s');
                    $toDate = (new Carbon($dateRange[1]))->format('Y-m-d H:i:s');
                }
                $orders = $orders->whereBetween('created_at', [$fromDate, $toDate]);
            }

            return responder()->success($orders, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine())->respond();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrderView(Order $order):JsonResponse
    {
        try {
            return responder()->success($order, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * Returns notes for specific order
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotes(Order $order):JsonResponse
    {
        try {
            return responder()->success($order->notes, OrderNoteTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * returns data for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Order $order):JsonResponse
    {
        try {
            return responder()->success($order, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order):JsonResponse
    {
        try {
            $validated = $request->validated();
            $order->buyer_details = $validated['buyer_details'];
            $order->status = $validated['status'];
            $order->save();
            return responder()->success($order)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return responder()->success(Order::all(), OrderTransformer::class)->respond(200);
    }
}
