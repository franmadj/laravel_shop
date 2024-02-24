<?php

namespace App\Transformers;

use App\Models\Order;
use Flugg\Responder\Transformers\Transformer;

class OrderTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = ['orderItems'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Order $order
     * @return array
     */
    public function transform(Order $order)
    {
        $data=$order->toArray();
        $data['date']=$order->created_at->format('Y M, d h:i:s a');
        $data['buyer_name']=$order->buyer_name;
        $data['notes']=$order->notes;
        return $data;
    }
}
