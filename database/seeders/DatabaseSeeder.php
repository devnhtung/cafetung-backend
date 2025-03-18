<?php
// database/seeders/DatabaseSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Product;
use Database\Seeders\UserSeeder;
use Database\Seeders\SliderSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SliderSeeder::class,
            ProductSeeder::class,
            PostSeeder::class,
        ]);
    }
}
