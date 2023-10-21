<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionRepository implements TransactionRepositoryInterface
{

    protected $transaction;

    public function __construct(Transaction $transaction){
        $this->transaction = $transaction;
    }

    public function getStatusCode($code){

        $statusKey =
            [
                'authorized' => $this->transaction::STATUS_AUTHORIZED,
                'decline' => $this->transaction::STATUS_DECLINE,
                'refunded' => $this->transaction::STATUS_REFUNDED,
            ];
        return str_replace(array_keys($statusKey), array_values($statusKey), $code);
    }
}
