<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Section;
use App\Models\User;
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
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'fname' => 'John',
            'lname' => 'Doe',
            'avatar' => 'avatar.png',
            'role' => 'admin',
        ]);
    }
}
