<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            [1, '干锅系列'],
            [2, '鱼'],
            [3, '鸡'],
            [4, '肉'],
            [9, '回锅肉'],
            [10, '菜'],
            [13, '清炒'],
            [14, '蛋'],
            [15, '汤'],
            [16, '凉拌'],
            [17, '火锅配菜（小食）'],
            [18, '饮料'],
            [19, ' 套餐'],
            [20, '招牌菜'],
            [21, '火锅配菜（鱼丸/海鲜类）'],
            [23, '火锅配菜（肉类）'],
            [24, '煎炸类'],
            [25, '火锅配菜（蔬菜类）'],
            [26, '啤酒'],
            [28, '格价菜'],
            [29, ' 海鲜'],
        ];
        foreach ($arr as $a){
            $icon = '<svg viewBox="-235.52 -235.52 1495.04 1495.04" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#8cff00" d="M128 352.576V352a288 288 0 0 1 491.072-204.224 192 192 0 0 1 274.24 204.48 64 64 0 0 1 57.216 74.24C921.6 600.512 850.048 710.656 736 756.992V800a96 96 0 0 1-96 96H384a96 96 0 0 1-96-96v-43.008c-114.048-46.336-185.6-156.48-214.528-330.496A64 64 0 0 1 128 352.64zm64-.576h64a160 160 0 0 1 320 0h64a224 224 0 0 0-448 0zm128 0h192a96 96 0 0 0-192 0zm439.424 0h68.544A128.256 128.256 0 0 0 704 192c-15.36 0-29.952 2.688-43.52 7.616 11.328 18.176 20.672 37.76 27.84 58.304A64.128 64.128 0 0 1 759.424 352zM672 768H352v32a32 32 0 0 0 32 32h256a32 32 0 0 0 32-32v-32zm-342.528-64h365.056c101.504-32.64 165.76-124.928 192.896-288H136.576c27.136 163.072 91.392 255.36 192.896 288z"></path></g></svg>';
            Categories::create([
                'id'=>$a[0],
                'name'=> trim($a[1]),
                'icon'=>$icon,
            ]);
        }
    }
}

