<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Transformers\OrderNoteTransformer;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $orders = new Order;
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
                if(!empty($dateRange[0]) && !empty($dateRange[1])){
                    $fromDate = (new Carbon($dateRange[0]))->format('Y-m-d H:i:s');
                    $toDate = (new Carbon($dateRange[1]))->format('Y-m-d H:i:s');
                }
                $orders = $orders->whereBetween('created_at', [$fromDate,$toDate]);
            }

            return responder()->success($orders, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine())->respond();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOrders()
    {
        try {

            $orders = new Order;
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
                if(!empty($dateRange[0]) && !empty($dateRange[1])){
                    $fromDate = (new Carbon($dateRange[0]))->format('Y-m-d H:i:s');
                    $toDate = (new Carbon($dateRange[1]))->format('Y-m-d H:i:s');
                }
                $orders = $orders->whereBetween('created_at', [$fromDate,$toDate]);
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
     * @return \Illuminate\Http\Response
     */
    public function myOrderView(Order $order)
    {
        try {
            return responder()->success($order, OrderTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
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
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function getNotes(Order $order)
    {
        try {
            return responder()->success($order->notes, OrderNoteTransformer::class)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        // try {

        $validated = $request->validated();

        $order->buyer_details = $validated['buyer_details'];
        $order->status = $validated['status'];
        $order->save();

        return responder()->success($order)->respond(200);

        //} catch (\Exception $e) {
        return responder()->error($e->getMessage())->respond();
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
