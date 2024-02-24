<?php

namespace App\Transformers;

use App\Models\OrderNote;
use Flugg\Responder\Transformers\Transformer;

class OrderNoteTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\OrderNote $note
     * @return array
     */
    public function transform(OrderNote $note)
    {
        return [
            'id' => (int) $note->id,
            'note' => $note->note,
            'author' => $note->Author?$note->Author->name:'',
            'date' => $note->created_at->format('M d, Y \a\t h:i a'),

        ];
    }
}
