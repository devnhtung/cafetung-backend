<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tin tức',
            'Khuyến mãi',
            'Sự kiện',
            'Hướng dẫn',
            'Cà phê',
            'Đồ uống',
            'Ẩm thực',
            'Phong cách sống',
            'Review',
            'Công thức pha chế'
        ];

        foreach ($categories as $category) {
            PostCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Mô tả cho danh mục ' . $category,
            ]);
        }

        // posts
        $posts = [
            'Bí quyết pha Espresso ngon nhất',
            'Khuyến mãi đặc biệt tuần này',
            'Sự kiện thử cà phê miễn phí',
            'Cách tạo Latte Art chuyên nghiệp',
            'Thức uống tốt nhất cho mùa hè',
            'Review quán cà phê nổi tiếng tại Huế',
            'Tại sao cà phê Arabica lại được ưa chuộng?',
            'Công thức pha Cold Brew tại nhà',
            'Hành trình tìm kiếm hạt cà phê ngon nhất',
            'Cách bảo quản cà phê đúng cách'
        ];

        foreach ($posts as $title) {
            Post::create([
                'user_id' => 1, // Giả sử admin có ID = 1
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => 'Nội dung mẫu cho bài viết "' . $title . '"',
                'featured_image' => 'default.jpg',
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        $posts = Post::all();
        $categories = PostCategory::all();

        foreach ($posts as $post) {
            $post->categories()->attach($categories->random(rand(1, 2))->pluck('id')->toArray());
        }
    }
}
