<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
 
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'paidAmount' => $this->paid_amount,
            'Currency' => $this->currency,
            'parentEmail' => $this->parent_email,
            'statusCode' => $this->status_code,
            'paymentDate' => $this->payment_date,
            'parentIdentification' => $this->parent_identification,
            'user' => $this->user,
            
        ];
        
    }
}