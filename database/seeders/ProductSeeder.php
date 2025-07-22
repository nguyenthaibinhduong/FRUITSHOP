<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
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

        // Mảng ảnh Cloudinary
        $arr_image = [
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-1_aiexrr.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-2_zicvkg.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-3_ostt20.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-4_dfpwne.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460202/product-5_uyvu2f.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-6_q0hsb3.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-7_vuahop.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460201/product-8_tre5sb.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460202/product-9_aymsww.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460202/product-10_wbfpps.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460202/product-11_moizkm.jpg',
            'https://res.cloudinary.com/dvimvchbw/image/upload/v1752460203/product-12_iucibd.jpg'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $category = Category::find(mt_rand(1, 10));
            $brand = Brand::find(mt_rand(1, 4));

            // Insert product
            DB::table('products')->insert([
                'id' => $i,
                'name' => $category->name . ' ' . $brand->name . ' ' . mt_rand(100, 999),
                'description' => 'Sản phẩm ' . $category->name . ' ' . $brand->name . ' chất lượng cao 100%',
                'longdescription' => 'This is a long description of product ' . $i,
                'price' => mt_rand(100, 999) * 1000,
                'sale_percent' => Arr::random([0.8, 0.9, 0.7, 1]),
                'quantity' => Arr::random([0, 10, 20, 30, 100, 50, 60]),
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
