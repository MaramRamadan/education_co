<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
  
        $json = File::get(base_path("database/data/users.json"));
        $users = json_decode($json);
  
        foreach ($users->users as $key => $value) {
            User::create([
                "balance" => $value->balance,
                "currency" => $value->currency,
                "email" => $value->email,
                "created" => $value->created_at,
                "user_id" => $value->id
            ]);
        }
    }
}



  
