<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use File;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Admin::create([
            "name" => "Admin",  
            "email" => "admin@gmail.com",  
            "password" => bcrypt('password')
        ]);

        User::create([
            "name" => "User 1",  
            "email" => "user@gmail.com",  
            "password" => bcrypt('password'), 
        ]);

        // $now = date('Y-m-d H:i:s');
        // Product::insert([
        //     ["shop_id" => 1,  "name" => "Krabby Patty", "price" => 12500,   "created_at" => $now,"updated_at"=> $now],
        //     ["shop_id" => 1,  "name" => "Seafoam Soda", "price" => 10000,   "created_at" => $now,'updated_at'=> $now],
        //     ["shop_id" => 1,  "name" => "Krabby Meal",  "price" => 35000,   "created_at" => $now,'updated_at'=> $now],
        //     ["shop_id" => 1,  "name" => "Kelp Rings",   "price" => 15000,   "created_at" => $now,'updated_at'=> $now]
        // ]);

        // $posts = json_decode(File::get("database/data/posts.json"));
        // foreach ($posts as $key => $value) {
        //     Post::create([
        //         "title" => $value->title,
        //         "slug" => $value->slug,
        //         "body" => $value->body,
        //         "image" => $value->image,
        //     ]);
        // }
    }
}
