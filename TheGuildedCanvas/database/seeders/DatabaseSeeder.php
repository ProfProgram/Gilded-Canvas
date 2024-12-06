<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderReturn;
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
        
        /**
         * Users dummy data
         */

        $users = [
            [
                'name' => 'Fatima',
                'email' => 'Fatima@hotmail.com',
                'password' => '34897109843109874',
                'phone_number' => '987431841071847',
                'role' => 'User',
            ],
            [
                'name' => 'Ali',
                'email' => 'ali@hotmail.com',
                'password' => '874398480988741879051',
                'phone_number' => '987438721498743',
                'role' => 'User',
            ],
            [
                'name' => 'Eric',
                'email' => 'eric@hotmail.com',
                'password' => '89715984018741879841',
                'phone_number' => '874794187443142',
                'role' => 'User',
            ],
            [
                'name' => 'Jamal',
                'email' => 'jamal@hotmail.com',
                'password' => '657478',
                'phone_number' => '768904569872345',
                'role' => 'Admin',
            ],
            [
                'name' => 'Ammar',
                'email' => 'ammar@hotmail.com',
                'password' => '89747365972152187',
                'phone_number' => '785641978138746',
                'role' => 'Admin',
            ],
            [
                'name' => 'James',
                'email' => 'james@hotmail.com',
                'password' => '89747977832',
                'phone_number' => '478916287462148',
                'role' => 'Admin',
            ],
        ];

        foreach($users as $userData) {
            User::create($userData);
        }
    
    
        /**
         * Admin dummy data
         */

        $adminUsers = User::where('role', 'admin')->get();

        foreach ($adminUsers as $user) {
             // Check if the admin entry already exists for this user
            $existingAdmin = Admin::where('user_id', $user->user_id)->first();

             // If the Admin entry doesn't exist, create one
            if (!$existingAdmin) {
                Admin::create([
                    'user_id' => $user->user_id,
                ]);
            }
        }

        /**
         * Product dummy data
         */
        $products = [
            [
                'category_name' => 'Category 1',
                'product_name' => 'Name 1',
                'price' => 10,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'category_name' => 'Category 2',
                'product_name' => 'Name 2',
                'price' => 50,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'category_name' => 'Category 3',
                'product_name' => 'Name 3',
                'price' => 75,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
        ];

        foreach($products as $productData) {
            Product::create($productData);
        }

        /**
         * inventory dummmy data
         */
        $inventory = [
            [
                'product_id' => 1,
                'admin_id' => 1,
                'stock_level' => 150,
            ],
            [
                'product_id' => 2,
                'admin_id' => 2,
                'stock_level' => 230,
            ],
            [
                'product_id' => 3,
                'admin_id' => 3,
                'stock_level' => 300,
            ],
        ];
        foreach($inventory as $invData) {
            Inventory::create($invData);
        }

        /**
         * Orders dummy data
         */
        $orders =[
            [
                'admin_id' => 1,
                'user_id' => 1,
                'status' => 'Pending',
            ],
            [
                'admin_id' => 2,
                'user_id' => 2,
                'status' => 'Delivered',
            ],
            [
                'admin_id' => 3,
                'user_id' => 3,
                'status' => 'Shipped',
            ],
        ];
        foreach($orders as $orderData) {
            Order::create($orderData);
        }

        /**
         * order details dummy data
         */
        $orderDetails =[
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 5,
                'price_of_order' => 543,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 4,
                'price_of_order' => 320,
            ],
            [
                'order_id' => 3,
                'product_id' => 3,
                'quantity' => 1,
                'price_of_order' => 60,
            ],
        ];
        foreach($orderDetails as $detailsData) {
            OrderDetail::firstOrCreate($detailsData);
        }

        /**
         * reviews dummy data
         */
        $reviews = [
            [
                'user_id' => 1,
                'product_id' => 1,
                'rating' => 5,
                'review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'rating' => 4,
                'review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'user_id' => 3,
                'product_id' => 3,
                'rating' => 5,
                'review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',    
            ],
        ];
        foreach($reviews as $reviewData) {
            Review::firstOrCreate($reviewData);
        }
        /**
          * returns dummy data
          */
        // not needed for MVP
        // $returns = [
        //     [
        //         'order_id' => 1,
        //         'product_id' => 1,
        //         'user_id' => 1,
        //         'admin_id' => 1,
        //         'return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //         'return_status' => 'Refunded',
        //         'return_date' => '2024-11-19 17:04:30',
        //     ],
        //     [
        //         'Order_id' => 2,
        //         'Product_id' => 2,
        //         'User_id' => 2,
        //         'Admin_id' => 2,
        //         'Return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //         'Return_status' => 'Approved',
        //         'Return_date' => '2024-11-19 17:04:30',
        //     ],
        //     [
        //         'Order_id' => 3,
        //         'Product_id' => 3,
        //         'User_id' => 3,
        //         'Admin_id' => 3,
        //         'Return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //         'Return_status' => 'Cancelled',
        //         'Return_date' => '2024-11-19 17:04:30',
        //     ],
        // ];
        // foreach($returns as $returnData) {
        //     OrderReturn::firstOrCreate($returnData);
        // }
    }
}
