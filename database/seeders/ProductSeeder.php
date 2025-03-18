<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo danh mục
        $coffee = Category::create(['name' => 'Cà Phê', 'description' => 'Các loại cà phê']);
        $tea = Category::create(['name' => 'Trà', 'description' => 'Các loại trà']);
        $juice = Category::create(['name' => 'Nước Ép', 'description' => 'Các loại nước ép']);
        $yogurt = Category::create(['name' => 'Sữa Chua', 'description' => 'Các loại sữa chua']);
        $smoothie = Category::create(['name' => 'Đá xay', 'description' => 'Các loại đá xay']);
        $latte = Category::create(['name' => 'Matcha Latte', 'description' => 'Các loại matcha latte']);
        $cocoa = Category::create(['name' => 'Ca cao', 'description' => 'Các loại sữa ca cao']);

        $products = [   // Cà Phê
            [
                'name' => 'Espresso Fine Ro',
                'description' => 'Cà phê espresso đậm đà',
                'price' => 15000,
                'image' => 'espresso.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],
            [
                'name' => 'Espresso Fine Ro (Sữa)',
                'price' => 17000,
                'image' => 'espresso_milk.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],
            [
                'name' => 'Americano Fine Ro',
                'price' => 22000,
                'image' => 'americano.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],
            [
                'name' => 'Cappuccino Latte',
                'price' => 35000,
                'image' => 'cappuccino.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],
            [
                'name' => 'Cà Phê Muối',
                'price' => 26000,
                'image' => 'salt_coffee.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],
            [
                'name' => 'Cà Phê Dừa Đá',
                'price' => 32000,
                'image' => 'coconut_coffee.jpg',
                'category_id' => $coffee->id,
                'is_available' => true,
            ],

            // Trà Ô Long
            [
                'name' => 'O Long Kem Cheese',
                'price' => 35000,
                'image' => 'oolong_cheese.jpg',
                'category_id' => $tea->id,
                'is_available' => true,
            ],
            [
                'name' => 'O Long Xoài Đào Kem Cheese',
                'price' => 35000,
                'image' => 'oolong_mango.jpg',
                'category_id' => $tea->id,
                'is_available' => true,
            ],
            [
                'name' => 'Trà Đào Sữa',
                'price' => 34000,
                'image' => 'peach_milk_tea.jpg',
                'category_id' => $tea->id,
                'is_available' => true,
            ],
            [
                'name' => 'Trà Cam Quế Mật Ong',
                'price' => 35000,
                'image' => 'orange_cinnamon_tea.jpg',
                'category_id' => $tea->id,
                'is_available' => true,
            ],

            // Nước Ép
            [
                'name' => 'Nước Ép Cam',
                'price' => 30000,
                'image' => 'orange_juice.jpg',
                'category_id' => $juice->id,
                'is_available' => true,
            ],
            ['name' => 'Nước Ép Mix (2 vị)', 'price' => 32000, 'image' => 'mix_juice.jpg', 'category_id' => $juice->id],
            ['name' => 'Cần Tây Táo Dứa', 'price' => 35000, 'image' => 'celery_apple_pineapple.jpg', 'category_id' => $juice->id],

            // Sữa Chua
            ['name' => 'Sữa Chua Xoài', 'price' => 30000, 'image' => 'yogurt_mango.jpg', 'category_id' => $yogurt->id],
            ['name' => 'Sữa Chua Chanh Dây', 'price' => 30000, 'image' => 'yogurt_passion_fruit.jpg', 'category_id' => $yogurt->id],

            // Đá Xay
            ['name' => 'Bơ Đá Xay', 'price' => 32000, 'image' => 'avocado_smoothie.jpg', 'category_id' => $smoothie->id],
            ['name' => 'Xoài Dâu Đá Xay', 'price' => 32000, 'image' => 'mango_strawberry_smoothie.jpg', 'category_id' => $smoothie->id],
            ['name' => 'Matcha Dừa Đá Xay', 'price' => 35000, 'image' => 'matcha_coconut_smoothie.jpg', 'category_id' => $smoothie->id],

            // Special Latte
            ['name' => 'Matcha Latte', 'price' => 32000, 'image' => 'matcha_latte.jpg', 'category_id' => $latte->id],
            ['name' => 'Matcha Latte Mango', 'price' => 35000, 'image' => 'matcha_mango_latte.jpg', 'category_id' => $latte->id],

            // Sữa Ca Cao
            ['name' => 'Ca Cao Nóng', 'price' => 30000, 'image' => 'hot_cocoa.jpg', 'category_id' => $cocoa->id],
            ['name' => 'Ca Cao Đá', 'price' => 30000, 'image' => 'iced_cocoa.jpg', 'category_id' => $cocoa->id],
            ['name' => 'Ca Cao Dừa', 'price' => 34000, 'image' => 'cocoa_coconut.jpg', 'category_id' => $cocoa->id],
        ];
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
