<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Insert categories
         DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Rau củ'],
            ['id' => 2, 'name' => 'Trái cây'],
            ['id' => 3, 'name' => 'Thức ăn nhanh'],
            ['id' => 4, 'name' => 'Đồ gia dụng'],
            ['id' => 5, 'name' => 'Thịt tươi'],
            ['id' => 6, 'name' => 'Nước ngọt'],
            ['id' => 7, 'name' => 'Gia vị'],
            ['id' => 8, 'name' => 'Thực phẩm sạch'],
            ['id' => 9, 'name' => 'Thịt đông lạnh'],
            ['id' => 10, 'name' => 'Đồ uống có cồn']
        ]);

        // Insert brands
        DB::table('brands')->insert([
            ['id' => 1, 'name' => 'Win'],
            ['id' => 2, 'name' => 'Vissan'],
            ['id' => 3, 'name' => 'Chinsu'],
            ['id' => 4, 'name' => 'Meatdeli'],
        ]);

        $productImage_link = 'img/product/';
        $arr_image = [];
        for ($i = 1; $i <= 12; $i++) {
            array_push($arr_image, $productImage_link . 'product-' . $i . '.jpg');
        }

        for ($i = 1; $i <= 100; $i++) {
            $category = Category::find(mt_rand(1, 10));
            $brand = Brand::find(mt_rand(1, 4));
            
            // Insert product
            DB::table('products')->insert([
                'id' => $i,
                'name' => $category->name . ' ' . $brand->name . ' ' . mt_rand(100, 999),
                'description' => 'Sản phẩm '.$category->name . ' ' . $brand->name . ' ' . mt_rand(100, 999) .' chất lượng cao 100%',
                'longdescription' => 'This is a long description of product ',
                'price' => (mt_rand(100, 999))*1000,
                'sale_percent' => Arr::random([0.8,0.9,0.7,1]),
                'quantity' => Arr::random([0,10,20,30,100,50,60]),
                'uploaded' => 1,
                'brand_id' => $brand->id
            ]);

            // Insert product image
            DB::table('product_images')->insert([
                'product_id' => $i,
                'url' => Arr::random($arr_image),
                'image_type' => 0
            ]);

            // Insert product category
            DB::table('product_categories')->insert([
                'product_id' => $i,
                'category_id' => $category->id
            ]);
        }
    }
}
