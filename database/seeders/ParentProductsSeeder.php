<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentProductsSeeder extends Seeder
{
    public function run()
    {
        DB::table('parent_products')->insert([
            [
                'name' => 'Iphone 16 promax',
                'id_brand' => 1,
                'desc' => 'Đây là chiếc điện thoại mới nhất của hãng Apple cho ra mắt vào thị trường tháng 9/2024.',
                'short_desc' => '- Hiệu năng mạnh mẽ\r\n- Dung lượng pin khủng\r\n- Camera được update cực nét\r\n- Màn hình full HD sắc nét',
                'avatar' => null,
                'rating' => 5,
                'is_variant_product' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xiaomi note 8pro',
                'id_brand' => 6,
                'desc' => 'Đây là chiếc điện thoại mới nhất của hãng xiaomi cho ra mắt vào thị trường tháng 9/2024.',
                'short_desc' => '- Hiệu năng mạnh mẽ\r\n- Dung lượng pin khủng\r\n- Camera được update cực nét\r\n- Màn hình full HD sắc nét',
                'avatar' => null,
                'rating' => 4,
                'is_variant_product' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
