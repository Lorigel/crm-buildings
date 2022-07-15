<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Direzione',
            'slug' => 'admin',
            'priority' => 1,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Master',
            'slug' => 'master',
            'priority' => 2,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Supervizore',
            'slug' => 'supervisor',
            'priority' => 3,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Manager',
            'slug' => 'manager',
            'priority' => 4,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Coordinatore',
            'slug' => 'cordinator',
            'priority' => 5,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Senior',
            'slug' => 'senior',
            'priority' => 6,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Junior',
            'slug' => 'junior',
            'priority' => 7,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'General contractor',
            'slug' => 'general-contractor',
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Tecnico',
            'slug' => 'technic',
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'Azienda',
            'slug' => 'company',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    
    }
}
