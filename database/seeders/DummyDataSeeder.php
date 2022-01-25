<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //dummy categories
        $dummy_categories = [
            ['name' => "Chairs", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 0, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Wooden Chairs", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 1, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Sofa set", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 1, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Tables", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 0, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Wooden Tables", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 4, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Computer Tables", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 4, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Lamps", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 0, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Decorative Lamps", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 7, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Table Lamps", 'description' => "Lorem ipsum iptum flores dummy for example.", 'parent' => 7, 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
        ];
        //empty existing data if any
        DB::table('categories')->truncate();
        //insert dummy data
        DB::table('categories')->insert($dummy_categories);

        //dummy categories
        $dummy_products = [
            ['name' => "Sofa Table Set", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 3, 'image_id' => 1, 'price' => '65', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Wood Chair", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 2, 'image_id' => 2, 'price' => '45', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Multipurpose Table", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 5, 'image_id' => 3, 'price' => '25', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Decorative Lamp", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 8, 'image_id' => 4, 'price' => '20', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Computer Table", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 5, 'image_id' => 5, 'price' => '50', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Table Lamp", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 9, 'image_id' => 6, 'price' => '15', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Sofa Set", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 3, 'image_id' => 7, 'price' => '55', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Decorative Lamp", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 8, 'image_id' => 8, 'price' => '10', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "Wood Dining Table", 'description' => "Lorem ipsum iptum flores dummy for example.", 'active_status' => "active", 'sku' => "10", 'category_id' => 5, 'image_id' => 9, 'price' => '45', 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
        ];
        //empty existing data if any
        DB::table('products')->truncate();
        //insert dummy data
        DB::table('products')->insert($dummy_products);

        //dummy categories
        $dummy_image_gallery = [
            ['name' => "sofa-table-set.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "wood-chair.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "multipurpose-table.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "decorative-lamp.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "computer-table.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "table-lamp.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "sofa-set.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "decorative-lamp.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
            ['name' => "wood-dining-table.jpg", 'created_at' => Carbon::today()->toDateTimeString(), 'updated_at' => Carbon::today()->toDateTimeString()],
        ];
        //empty existing data if any
        DB::table('image_gallery')->truncate();
        //insert dummy data
        DB::table('image_gallery')->insert($dummy_image_gallery);
    }
}