<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request):JsonResponse
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

}
