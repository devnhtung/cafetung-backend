<?php
// database/seeders/DatabaseSeeder.php
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo người dùng
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Tạo danh mục
        $coffee = Category::create(['name' => 'Cà Phê', 'description' => 'Các loại cà phê']);
        $tea = Category::create(['name' => 'Trà', 'description' => 'Các loại trà']);
        $juice = Category::create(['name' => 'Nước Ép', 'description' => 'Các loại nước ép']);
        $yogurt = Category::create(['name' => 'Sữa Chua', 'description' => 'Các loại sữa chua']);
        $smoothie = Category::create(['name' => 'Đá xay', 'description' => 'Các loại đá xay']);
        $latte = Category::create(['name' => 'Matcha Latte', 'description' => 'Các loại matcha latte']);
        $cocoa = Category::create(['name' => 'Ca cao', 'description' => 'Các loại sữa ca cao']);

        // Tạo sản phẩm
        Product::create([
            'category_id' => $coffee->id,
            'name' => 'Espresso Fine Ro',
            'description' => 'Cà phê espresso đậm đà',
            'price' => 15000,
            'image' => 'espresso.jpg',
            'is_available' => true,
        ]);

        Product::create([
            'category_id' => $tea->id,
            'name' => 'Trà Ô Long',
            'description' => 'Trà Ô Long thơm ngon',
            'price' => 35000,
            'image' => 'oolong.jpg',
            'is_available' => true,
        ]);
        Product::create([
            'category_id' => $latte->id,
            'name' => 'Matcha Latte',
            'description' => 'Matcha Latte',
            'price' => 35000,
            'image' => 'matcha.jpg',
            'is_available' => true,
        ]);
        Product::create([
            'category_id' => $cocoa->id,
            'name' => 'Ca Cao Nóng',
            'description' => 'Ca Cao Nóng',
            'price' => 30000,
            'image' => 'cacao.jpg',
            'is_available' => true,
        ]);
        Product::create([
            'category_id' => $cocoa->id,
            'name' => 'Ca Cao Nóng',
            'description' => 'Ca Cao Nóng',
            'price' => 30000,
            'image' => 'cacao.jpg',
            'is_available' => true,
        ]);

        // Tạo slider
        Slider::create([
            'title' => 'Nâng tầm ngày của bạn với Cà Phê',
            'description' => 'Khám phá cà phê hảo hạng, rang xay chuẩn vị',
            'background_image' => 'slide1.jpg',
            'button_text' => 'Khám phá ngay',
            'button_link' => '/menu',
            'is_active' => true,
            'order' => 1,
        ]);
    }
}
