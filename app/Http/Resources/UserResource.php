<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'balance' => $this->balance,
            'currency' => $this->currency,
            'email' => $this->email,
            'created_at' => $this->created,
            'transactions' => $this->transactions,

        ];
    }

}
