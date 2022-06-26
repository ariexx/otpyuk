<?php

namespace Database\Seeders;

use App\Models\Deposit;
use App\Models\DepositMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::factory(1)->create();
        \App\Models\User::factory(5)->create();
        \App\Models\Rate::factory(1)->create(); //jalankan hanya sekali
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'telkomsel',
        ]);
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'axis',
        ]);
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'indosat',
        ]);
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'three',
        ]);
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'smartfren',
        ]);
        \App\Models\Operator::factory(1)->create([
            'operator_name' => 'any',
        ]);
        \App\Models\Service::factory(100)->create();
        \App\Models\Order::factory(3)->create();
        DepositMethod::factory(1)->create();
        Deposit::factory(1)->create();
    }
}
