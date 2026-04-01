<?php

namespace Database\Seeders;

use App\Models\Desk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<20;$i++){
            $arr = [
                'name'=>'Table '.($i+1),
                'code'=>'T'.($i+1)
            ];
            Desk::create($arr);
        }
    }
}
