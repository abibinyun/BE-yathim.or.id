<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123'
        ]);

        $this->call($this->devSeeder());
    }

    protected function devSeeder()
    {
        return [
            PageBannerSeeder::class,
            SiteSettingSeeder::class,
            CategorySeeder::class
        ];
    }
}


    // public function run()
    // {
    //     if (env('APP_ENV') === 'testing') {
    //         // Testing Seeder
    //         $this->call([]);
    //     } elseif (env('APP_ENV') === 'local') {
    //         // Local Seeder [Dev]
    //         $this->call(array_merge($this->productionSeeder(), $this->devSeeder()));

    //     } else {
    //         // Production Seeder
    //         $this->call($this->productionSeeder());
    //     }

    // }

    // protected function devSeeder()
    // {
    //     return [
    //         UserSeeder::class,
    //         anotherSeeder::class,
    //         -----
    //         -----
    //     ];
    // }

    // protected function productionSeeder()
    // {
    //     return [
    //         UserSeeder::class,
    //         anotherSeeder::class,
    //         -----
    //         -----
    //     ];
    // }