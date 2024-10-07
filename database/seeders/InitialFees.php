<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Fee;
use App\Models\Profile;
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
           'amount' => 50.00
        ]);

        Fee::create([
            'particulars' => 'Monthly',
            'amount' => 950.00
        ]);

        Bed::create([
            'code' => 'R1B1',
            'description' => 'Room 1, Bed 1',
            'status' => 'Available',
            'remarks' => null
        ]);

        Bed::create([
            'code' => 'R1B2',
            'description' => 'Room 1, Bed 2',
            'status' => 'Available',
            'remarks' => null
        ]);

        Profile::create([
            'fname' => 'Anna',
            'lname' => 'Baron',
            'sex' => 'Female',
            'dob' => '1990-03-03',
            'contact' => '09161234567',
            'address' => 'Escalante City'
        ]);

        Profile::create([
            'fname' => 'Carl',
            'lname' => 'Durano',
            'sex' => 'Male',
            'dob' => '1989-06-23',
            'contact' => '09123456789',
            'address' => 'Sagay City'
        ]);
    }
}
