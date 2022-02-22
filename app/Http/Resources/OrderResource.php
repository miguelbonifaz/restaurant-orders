<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'table_number' => $this->table_number,
            'client_name' => $this->client_name,
            'foods_count' => $this->foods_count,
            'foods' => MenuCollection::make($this->whenLoaded('foods')),
        ];
    }
}
