<?php

namespace Database\Seeders;

use App\Models\Restro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restro::create([
            'name'=>'CHINESE FARM RESTAURANT',
            'logotxt'=>'农家乐餐馆',
            'addr'=>'No. 86, Rangoon Road.10400 Geogertown. Penang.<br>04-2189939/0165536563/0195635222',
        ]);
    }
}
