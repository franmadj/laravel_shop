<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        try {

            $validated = $request->validated();
            $buyer_details = [
                'first_name',
                'last_name',
                'email',
                'address',
                'suite',
                'town',
                'state',
                'pc',
                'phone',
                'notes',
            ];
            $validated['buyer_details'] = array_filter($validated, function ($item) use ($buyer_details) {
                return in_array($item, $buyer_details);
            }, ARRAY_FILTER_USE_KEY);
            $validated = array_filter($validated, function ($item) use ($buyer_details) {
                return !in_array($item, $buyer_details);
            }, ARRAY_FILTER_USE_KEY);

            //dd($validated);
            $order = Order::create($validated);

            foreach ($validated['cart_items'] as $item) {
                $order->orderItems()->create([
                    'type' => $item['isVariable'] ? 'variation' : 'simple',
                    'product_id' => $item['id'],
                    'title' => $item['isVariable'] ? $item['title'] . ' ' . $item['variation']['name'] : $item['title'],
                    'variation_id' => $item['isVariable'] ? $item['variation']['id'] : null,
                    'price' => $item['isVariable'] ? $item['variation']['price'] : $item['price'],
                ]);

            }
            return responder()->success($order)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
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
        //
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
