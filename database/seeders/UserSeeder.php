<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Lorigela',
            'surname' => 'Karaj',
            'email' => 'lorigela@gmail.com',
            'role' => 1,
            'username' => 'lori',
            'email_verified_at' => \Carbon\Carbon::now(),
            'account_verified_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'password' => bcrypt('lorigela@gmail.com'),
        ]);
    }
}
