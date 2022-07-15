<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'ECOBONUS 110% BIFAMILIARE',
            'slug' => 'ecobonus_two_family',
        ]);
        DB::table('products')->insert([
            'name' => 'ECOBONUS 110% CONDOMINIO',
            'slug' => 'ecobonus_condominium',
        ]);
        DB::table('products')->insert([
            'name' => 'ECOBONUS 110% UNITA\' SINGOLA',
            'slug' => 'ecobonus_single_unit',
        ]);
        DB::table('products')->insert([
            'name' => 'ECOSISMABONUS 110% CONDOMINIO',
            'slug' => 'ecosismabonus_condominium',
        ]);
        DB::table('products')->insert([
            'name' => 'ECOSISMABONUS 110% UNITA\' SINGOLA',
            'slug' => 'ecosismabonus_single_unit',
        ]);
        DB::table('products')->insert([
            'name' => 'SISMABONUS  110% CONDOMINIO',
            'slug' => 'sismabonus_condominium',
        ]);
        DB::table('products')->insert([
            'name' => 'SISMABONUS 110% UNITA\' SINGOLA',
            'slug' => 'sismabonus_single_unit',
        ]);
    }
}
