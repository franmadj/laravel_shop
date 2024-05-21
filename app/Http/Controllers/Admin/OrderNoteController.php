<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderNoteRequest;
use App\Http\Requests\UpdateOrderNoteRequest;
use App\Models\OrderNote;
use Illuminate\Http\JsonResponse;

class OrderNoteController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderNoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderNoteRequest $request):JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated = $validated + ['user_id' => Auth()->user()->id];
            OrderNote::create($validated);
            return responder()->success()->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($orderNote):JsonResponse
    {
        try {
            $orderNote = OrderNote::findOrFail($orderNote);
            $orderNote->delete();
            return responder()->success()->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getMessage())->respond();
        }
    }
}
