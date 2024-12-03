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
                'Name' => 'Fatima',
                'Email' => 'Fatima@hotmail.com',
                'Password' => '34897109843109874',
                'Phone_number' => '987431841071847',
                'Role' => 'User',
            ],
            [
                'Name' => 'Ali',
                'Email' => 'ali@hotmail.com',
                'Password' => '874398480988741879051',
                'Phone_number' => '987438721498743',
                'Role' => 'User',
            ],
            [
                'Name' => 'Eric',
                'Email' => 'eric@hotmail.com',
                'Password' => '89715984018741879841',
                'Phone_number' => '874794187443142',
                'Role' => 'User',
            ],
            [
                'Name' => 'Jamal',
                'Email' => 'jamal@hotmail.com',
                'Password' => '657478',
                'Phone_number' => '768904569872345',
                'Role' => 'Admin',
            ],
            [
                'Name' => 'Ammar',
                'Email' => 'ammar@hotmail.com',
                'Password' => '89747365972152187',
                'Phone_number' => '785641978138746',
                'Role' => 'Admin',
            ],
            [
                'Name' => 'James',
                'Email' => 'james@hotmail.com',
                'Password' => '89747977832',
                'Phone_number' => '478916287462148',
                'Role' => 'Admin',
            ],
        ];

        foreach($users as $userData) {
            User::create($userData);
        }
    
    
        /**
         * Admin dummy data
         */

        $adminUsers = User::where('Role', 'Admin')->get();

        foreach ($adminUsers as $user) {
             // Check if the admin entry already exists for this user
            $existingAdmin = Admin::where('User_id', $user->User_id)->first();

             // If the Admin entry doesn't exist, create one
            if (!$existingAdmin) {
                Admin::create([
                    'User_id' => $user->User_id,
                ]);
            }
        }

        /**
         * Product dummy data
         */
        $products = [
            [
                'Category_name' => 'Category 1',
                'Product_name' => 'Name 1',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'Category_name' => 'Category 2',
                'Product_name' => 'Name 2',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'Category_name' => 'Category 3',
                'Product_name' => 'Name 3',

                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
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
                'Product_id' => 1,
                'Admin_id' => 1,
                'Stock_in' => 40,
                'Stock_out' => 50,
                'Stock_level' => 150,
            ],
            [
                'Product_id' => 2,
                'Admin_id' => 2,
                'Stock_in' => 54,
                'Stock_out' => 43,
                'Stock_level' => 230,
            ],
            [
                'Product_id' => 3,
                'Admin_id' => 3,
                'Stock_in' => 76,
                'Stock_out' => 82,
                'Stock_level' => 300,
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
                'Admin_id' => 1,
                'User_id' => 1,
                'Status' => 'Pending',
            ],
            [
                'Admin_id' => 2,
                'User_id' => 2,
                'Status' => 'Delivered',
            ],
            [
                'Admin_id' => 3,
                'User_id' => 3,
                'Status' => 'Shipped',
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
                'Order_id' => 1,
                'Product_id' => 1,
                'Quantity' => 5,
                'Price_of_order' => 543,
            ],
            [
                'Order_id' => 2,
                'Product_id' => 2,
                'Quantity' => 4,
                'Price_of_order' => 320,
            ],
            [
                'Order_id' => 3,
                'Product_id' => 3,
                'Quantity' => 1,
                'Price_of_order' => 60,
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
                'User_id' => 1,
                'Product_id' => 1,
                'Rating' => 5,
                'Review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'User_id' => 2,
                'Product_id' => 2,
                'Rating' => 4,
                'Review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            [
                'User_id' => 3,
                'Product_id' => 3,
                'Rating' => 5,
                'Review_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',    
            ],
        ];
        foreach($reviews as $reviewData) {
            Review::firstOrCreate($reviewData);
        }
        /**
          * returns dummy data
          */
        $returns = [
            [
                'Order_id' => 1,
                'Product_id' => 1,
                'User_id' => 1,
                'Admin_id' => 1,
                'Return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'Return_status' => 'Refunded',
                'Return_date' => '2024-11-19 17:04:30',
            ],
            [
                'Order_id' => 2,
                'Product_id' => 2,
                'User_id' => 2,
                'Admin_id' => 2,
                'Return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'Return_status' => 'Approved',
                'Return_date' => '2024-11-19 17:04:30',
            ],
            [
                'Order_id' => 3,
                'Product_id' => 3,
                'User_id' => 3,
                'Admin_id' => 3,
                'Return_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'Return_status' => 'Cancelled',
                'Return_date' => '2024-11-19 17:04:30',
            ],
        ];
        foreach($returns as $returnData) {
            OrderReturn::firstOrCreate($returnData);
        }
    }
}
