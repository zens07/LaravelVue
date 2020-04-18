<?php

use Illuminate\Database\Seeder;
use App\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Club::create([
            'name' => 'machester',
            'point' => 3,
        ]);
        Club::create([
            'name' => 'chelsea',
            'point' => 3,
        ]);
        Club::create([
            'name' => 'madrid',
            'point' => 3,
        ]);
    }
}
