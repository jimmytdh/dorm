<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialFees extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fee::create([
           'particulars' => 'Daily',
           'amount' => 200.00
        ]);

        Fee::create([
            'particulars' => 'Monthly',
            'amount' => 5000.00
        ]);
    }
}
