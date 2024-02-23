<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curs;
use App\Models\Trimestre;
use App\Models\Festiu;
use App\Models\Cicle;
use App\Models\NumDies;
use App\Models\Modul;
use App\Models\Uf;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Curs::factory(1)->
        has(\App\Models\Trimestre::factory()->count(3))->has(\App\Models\Festiu::factory()->count(103))
        ->create();

        \App\Models\Cicle::factory(1)
    ->has(\App\Models\Modul::factory()->count(7)
        ->has(\App\Models\Uf::factory()->count(4))
        ->has(\App\Models\NumDies::factory()->count(56))
    )
    ->create();

        
    }
}
