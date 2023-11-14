<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['php', 'Laravel', 'html', 'css', 'bootstrap', 'vue', 'js', 'mysql'];

        foreach ($technologies as $technology) {
            $new_tech = new Technology();

            $new_tech->tech = $technology;

            $new_tech->save();
        }
    }
}
