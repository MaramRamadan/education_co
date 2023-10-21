<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    private $result;

    public function filter(Request $request){

        if ($request->has('currency')) {
            $value = $request->input('currency');
            $this->getByCurrency($value);

        }elseif($request->has('date')) {
            $value = $request->input('date');
            $this->getByDateRange($value);

        }elseif($request->has('amount')){
            $value = $request->input('amount');
            $this->getByAmountRange($value);

        }elseif($request->has('status')){
            $value = $request->input('status');
            $this->getByStatus($value);
        }

        return Response::json([
            'transaction' => TransactionResource::collection($this->result)
        ], 201);
    }


    /**
     * authorized which will have statusCode 1
     * decline which will have statusCode 2
     * refunded which will have statusCode 3
    */

    private function getByStatus($value){
        $statusKey =
            [
                'authorized' => 1,
                'decline' => 2,
                'refunded' => 3

            ] ;

        $this->result = Transaction::with('user')->where('status_code', $statusKey[$value])->get();

    }

    private function getByCurrency($value){

        $this->result = Transaction::with('user')->where('Currency','like' ,$value)->get();

    }

    private function getByAmountRange($value){

        $range = explode(",",$value);
        sort($range);

        $this->result = Transaction::with('user')->whereBetween('paid_amount', $range)->get();
    }

    private function getByDateRange($value){

        $range = explode(",",$value);
        sort($range);

        $this->result = Transaction::with('user')->whereBetween('payment_date', $range)->get();

    }

}
