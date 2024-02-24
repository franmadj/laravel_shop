<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderNoteRequest;
use App\Http\Requests\UpdateOrderNoteRequest;
use App\Models\OrderNote;
use Illuminate\Support\Facades\Auth;

class OrderNoteController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderNoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderNoteRequest $request)
    {
        $validated = $request->validated();
        $validated = $validated + ['user_id' => Auth()->user()->id];
        OrderNote::create($validated);
        return responder()->success()->respond(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function show(OrderNote $orderNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderNote $orderNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderNoteRequest  $request
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderNoteRequest $request, OrderNote $orderNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderNote)
    {
        $orderNote = OrderNote::findOrFail($orderNote);
        $orderNote->delete();
        return responder()->success()->respond(200);
    }
}
