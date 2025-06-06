<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

        foreach ($sizes as $size) {
            DB::table('sizes')->updateOrInsert(
                ['size_name' => $size],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
