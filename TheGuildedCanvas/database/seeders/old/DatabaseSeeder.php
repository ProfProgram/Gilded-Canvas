<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Returns;
use App\Models\Review;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert Admin Data
        $admin1 = Admin::firstOrCreate([
            'Admin_id' => 24688642,
            'Name' => 'Jamal',
            'Email' => 'jamal@hotmail.com',
            'Password' => '657478',
            'Phone_number' => '768904569872345',
            'Role' => 'Admin'
        ]);

        $admin2 = Admin::firstOrCreate([
            'Admin_id' => 47497688,
            'Name' => 'Ammar',
            'Email' => 'ammar@hotmail.com',
            'Password' => '89747365972152187',
            'Phone_number' => '785641978138746',
            'Role' => 'Admin'
        ]);

        $admin3 = Admin::firstOrCreate([
            'Admin_id' => 135797531,
            'Name' => 'James',
            'Email' => 'james@hotmail.com',
            'Password' => '89747977832',
            'Phone_number' => '478916287462148',
            'Role' => 'Admin'
        ]);

        // Insert Category Data
        $category1 = Category::firstOrCreate(['Category_id' => 1, 'Category_name' => 'Category 1']);
        $category2 = Category::firstOrCreate(['Category_id' => 2, 'Category_name' => 'Category 2']);
        $category3 = Category::firstOrCreate(['Category_id' => 3, 'Category_name' => 'Category 3']);

        // Insert User Data first
        $user1 = User::firstOrCreate([
            'User_id' => 1,
            'Name' => 'Fatima',
            'Email' => 'Fatima@hotmail.com',
            'Password' => '34897109843109874',
            'Phone_number' => '987431841071847',
            'Role' => 'User'
        ]);

        $user2 = User::firstOrCreate([
            'User_id' => 2,
            'Name' => 'Ali',
            'Email' => 'ali@hotmail.com',
            'Password' => '874398480988741879051',
            'Phone_number' => '987438721498743',
            'Role' => 'User'
        ]);

        $user3 = User::firstOrCreate([
            'User_id' => 3,
            'Name' => 'Eric',
            'Email' => 'eric@hotmail.com',
            'Password' => '89715984018741879841',
            'Phone_number' => '874794187443142',
            'Role' => 'User'
        ]);

        // Insert Product Data (now User data already exists)
        $product1 = Product::firstOrCreate([
            'Products_id' => 1,
            'Category_id' => 1,
            'Stock_level' => 100,
            'Product_image' => 'N/A',
            'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...'
        ]);

        $product2 = Product::firstOrCreate([
            'Products_id' => 2,
            'Category_id' => 2,
            'Stock_level' => 200,
            'Product_image' => 'N/A',
            'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...'
        ]);

        $product3 = Product::firstOrCreate([
            'Products_id' => 3,
            'Category_id' => 3,
            'Stock_level' => 300,
            'Product_image' => 'N/A',
            'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...'
        ]);

        // Insert Inventory Data (now Product data exists)
        $inventory1 = Inventory::firstOrCreate([
            'Inventory_id' => 1,
            'Product_id' => $product1->Products_id,
            'Admin_id' => $admin2->Admin_id,
            'Stock_in' => 40,
            'Stock_out' => 50,
            'Current_stock' => 150,
            'Threshold_level' => 100
        ]);

        $inventory2 = Inventory::firstOrCreate([
            'Inventory_id' => 2,
            'Product_id' => $product2->Products_id,
            'Admin_id' => $admin1->Admin_id,
            'Stock_in' => 54,
            'Stock_out' => 43,
            'Current_stock' => 230,
            'Threshold_level' => 200
        ]);

        $inventory3 = Inventory::firstOrCreate([
            'Inventory_id' => 3,
            'Product_id' => $product3->Products_id,
            'Admin_id' => $admin3->Admin_id,
            'Stock_in' => 76,
            'Stock_out' => 82,
            'Current_stock' => 300,
            'Threshold_level' => 200
        ]);

        // Now Insert Order Data (now User data exists)
        $order1 = Order::firstOrCreate([
            'Order_detail' => 1,
            'Total_price' => 11,
            'Order_data' => '2024-11-19 16:58:54',
            'Admin_id' => $admin2->Admin_id,
            'User_id' => $user1->User_id,
            'Status' => 'Pending'
        ]);

        $order2 = Order::firstOrCreate([
            'Order_detail' => 2,
            'Total_price' => 55,
            'Order_data' => '2024-11-19 16:58:54',
            'Admin_id' => $admin1->Admin_id,
            'User_id' => $user2->User_id,
            'Status' => 'Delivered'
        ]);

        $order3 = Order::firstOrCreate([
            'Order_detail' => 3,
            'Total_price' => 3279,
            'Order_data' => '2024-11-19 16:58:54',
            'Admin_id' => $admin3->Admin_id,
            'User_id' => $user3->User_id,
            'Status' => 'Shipped'
        ]);

        // Insert Return Data (you can keep this section as it is, no change needed)
        $return1 = Returns::firstOrCreate([
            'Return_id' => 1,
            'Order_id' => $order1->Order_id,
            'Product_id' => $product1->Products_id,
            'User_id' => $user1->User_id,
            'Admin_id' => $admin2->Admin_id,
            'Return_reason' => 'Lorem ipsum dolor sit amet...',
            'Return_status' => 'Refunded',
            'Return_date' => '2024-11-19 17:04:30'
        ]);

        $return2 = Returns::firstOrCreate([
            'Return_id' => 2,
            'Order_id' => $order2->Order_id,
            'Product_id' => $product2->Products_id,
            'User_id' => $user2->User_id,
            'Admin_id' => $admin1->Admin_id,
            'Return_reason' => 'Lorem ipsum dolor sit amet...',
            'Return_status' => 'Approved',
            'Return_date' => '2024-11-19 17:04:30'
        ]);

        $return3 = Returns::firstOrCreate([
            'Return_id' => 3,
            'Order_id' => $order3->Order_id,
            'Product_id' => $product3->Products_id,
            'User_id' => $user3->User_id,
            'Admin_id' => $admin3->Admin_id,
            'Return_reason' => 'Lorem ipsum dolor sit amet...',
            'Return_status' => 'Cancelled',
            'Return_date' => '2024-11-19 17:04:30'
        ]);

        // Insert Review Data
        $review1 = Review::firstOrCreate([
            'Review_id' => 1,
            'User_id' => $user1->User_id,
            'Product_id' => $product1->Products_id,
            'Rating' => 5,
            'Review_text' => 'Lorem ipsum dolor sit amet...',
            'Review_date' => '2024-11-19 17:07:44'
        ]);

        $review2 = Review::firstOrCreate([
            'Review_id' => 2,
            'User_id' => $user2->User_id,
            'Product_id' => $product2->Products_id,
            'Rating' => 4,
            'Review_text' => 'Lorem ipsum dolor sit amet...',
            'Review_date' => '2024-11-19 17:07:44'
        ]);

        $review3 = Review::firstOrCreate([
            'Review_id' => 3,
            'User_id' => $user3->User_id,
            'Product_id' => $product3->Products_id,
            'Rating' => 3,
            'Review_text' => 'Lorem ipsum dolor sit amet...',
            'Review_date' => '2024-11-19 17:07:44'
        ]);
    }
}
