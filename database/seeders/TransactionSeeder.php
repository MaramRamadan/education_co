<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use File;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();
  
        $json = File::get(base_path("database/data/transactions.json"));
        $transactions = json_decode($json);
  
        foreach ($transactions->transactions as $key => $value) {
            Transaction::create([
                "paid_amount" => $value->paidAmount,
                "currency" => $value->Currency,
                "parent_email" => $value->parentEmail,
                "status_code" => $value->statusCode,
                "payment_date" => $value->paymentDate,
                "parent_identification" => $value->parentIdentification,

            ]);
        }
    }
}
