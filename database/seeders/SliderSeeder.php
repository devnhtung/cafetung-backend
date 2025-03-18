<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slider::create([
            'title' => 'Nâng tầm ngày của bạn với Cà Phê',
            'description' => 'Khám phá cà phê hảo hạng, rang xay chuẩn vị',
            'background_image' => 'slide1.jpg',
            'button_text' => 'Khám phá ngay',
            'button_link' => '/menu',
            'is_active' => true,
            'order' => 1,
        ]);
        Slider::create([
            'title' => 'Thưởng thức Trà Ô Long Thơm ngon tuyệt vời',
            'description' => 'Trải nghiệm hương vị trà cao cấp',
            'background_image' => 'slide2.jpg',
            'button_text' => 'Khám phá ngay',
            'button_link' => '/menu',
            'is_active' => true,
            'order' => 2,
        ]);
        Slider::create([
            'title' => 'Tươi mát với Nước Ép 100% tự nhiên',
            'description' => '  Nước ép trái cây tươi ngon mỗi ngày',
            'background_image' => 'slide2.jpg',
            'button_text' => 'Khám phá ngay',
            'button_link' => '/menu',
            'is_active' => true,
            'order' => 3,
        ]);
    }
}
