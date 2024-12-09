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
use App\Models\Cart;
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
            // Category 1
            [
                'category_name' => 'Abstract Art',
                'product_name' => 'Serene Dream',
                'price' => 57,
                'description' => 'A soothing abstract painting with flowing patterns in turquoise, coral, and yellow, resembling gentle ripples and soft gradients for a calm and dreamy vibe',
            ],
            [
                'category_name' => 'Abstract Art',
                'product_name' => 'Colour Harmony',
                'price' => 40,
                'description' => 'This painting is full of mixed colours that blend and swirl together. Bright shades like red, blue, yellow, and green stand out, while softer colours like teal and peach balance it out. The shapes and strokes feel random but energetic, making it look creative and fun. It’s the kind of painting that lets you imagine your own meaning.',
            ],
            [
                'category_name' => 'Abstract Art',
                'product_name' => 'Earth Rhythm',
                'price' => 65,
                'description' => 'This painting uses earthy colours like green, orange, and navy blue to create a mix of flowing and geometric patterns. The textures make it feel both smooth and rough, adding depth. It looks calm but also bold, like nature’s balance between chaos and order. It’s a modern and grounded piece that feels timeless.',
            ],
            [
                'category_name' => 'Abstract Art',
                'product_name' => 'Silent Shadows',
                'price' => 70,
                'description' => 'An abstract painting of three women’s forms in earthy tones of blue, brown, beige, and green. The figures are subtle and flowing, creating a calm, mysterious vibe',
            ],
            [
                'category_name' => 'Abstract Art',
                'product_name' => 'Colour Wave',
                'price' => 35,
                'description' => 'A painting of a sharp, colourful wave in a circle. The bold colours stand out with clear edges, creating an energetic and striking design that grabs attention.',
            ],
            // Category 2
            [
                'category_name' => 'Nature Landscape',
                'product_name' => 'Golden Glow',
                'price' => 150,
                'description' => 'This painting depicts a stunning sunset over a calm lake, with vibrant hues of orange, pink, purple, and gold blending together. The lake mirrors the colours beautifully, while gentle ripples and silhouettes of trees or hills add depth and serenity to the scene.',
            ],
            [
                'category_name' => 'Nature Landscape',
                'product_name' => 'Peaceful Hills',
                'price' => 175,
                'description' => 'This painting shows a calm countryside with green hills and little white sheep scattered around. There’s a small stream running through, and the sky has soft clouds. It feels quiet and relaxing, like being in nature.',
            ],
            [
                'category_name' => 'Nature Landscape',
                'product_name' => 'Tranquil Valley',
                'price' => 120,
                'description' => 'This painting shows a peaceful countryside with green hills and a small stream running through it. There’s a stone bridge over the stream and a cozy farmhouse surrounded by trees. The sky is soft blue with a few white clouds, making the whole scene feel calm and quiet.',
            ],
            [
                'category_name' => 'Nature Landscape',
                'product_name' => 'Golden Fields',
                'price' => 100,
                'description' => 'This painting captures a quiet countryside with a golden wheat field stretching across the landscape. A winding dirt path adds depth, leading to a cozy farmhouse nestled among a few trees. The soft blue sky with scattered clouds gives the scene a bright and peaceful atmosphere.',
            ],
            [
                'category_name' => 'Nature Landscape',
                'product_name' => 'Calm Lake',
                'price' => 200,
                'description' => 'This painting shows a baby-blue lake surrounded by small green mountains. The water is smooth and reflects the light blue sky with soft clouds. The mountains are gentle and make the scene feel peaceful and quiet. It’s simple but really calming to look at.',
            ],
            // Category 3
            [
                'category_name' => 'Decorative',
                'product_name' => 'Golden Harmony Knot Sculpture',
                'price' => 220,
                'description' => 'Enhance your decor with the Golden Harmony Knot Sculpture. Its intricately crafted, interwoven design brings a sleek and contemporary vibe to your space, making it a standout addition to any setting.
                This gold-toned decorative piece is perfect for elevating your coffee table books, accentuating your shelving, or adding a chic touch to a console table.
                ',
            ],
            [
                'category_name' => 'Decorative',
                'product_name' => 'Gilded Frame Art',
                'price' => 199,
                'description' => 'This beautiful frame is made from wood and covered in a shiny gold plating. It has a classic, elegant look, perfect for displaying your favourite art or photos. The golden finish makes it stand out and adds a stylish touch to any room.',
            ],
            [
                'category_name' => 'Decorative',
                'product_name' => 'Golden Bloom Vase',
                'price' => 149,
                'description' => 'This golden vase has a unique textured surface that makes it stand out. It’s perfect for holding flowers or just as a decoration on its own. The gold finish gives it a warm and stylish look that works in any room.',
            ],
            [
                'category_name' => 'Decorative',
                'product_name' => 'Luxury Wall Clock',
                'price' => 249,
                'description' => 'This wall clock has a bold design with smooth gold finish. It looks fancy and adds a stylish touch to any room. The clock face is decorative and really catches your attention, making it great for a living room or hallway.',
            ],
            [
                'category_name' => 'Decorative',
                'product_name' => 'Classic Brown Frame',
                'price' => 85,
                'description' => 'This elegant brown frame is crafted from high-quality wood, offering a timeless and natural look. Its rich brown finish enhances the beauty of any artwork or photo displayed within it. The frame’s clean lines and sturdy construction make it perfect for both modern and traditional settings.',
            ],
            // Category 4
            [
                'category_name' => 'Figurative',
                'product_name' => 'Calm Figure',
                'price' => 55,
                'description' => 'This artwork shows a soft, abstract figure with gentle shapes and flowing colours like blue, grey, and beige. The background blends smoothly, giving it a peaceful and calm feeling. The design is simple but makes you think about the emotions behind it.',
            ],
            [
                'category_name' => 'Figurative',
                'product_name' => 'Quite Strength',
                'price' => 50,
                'description' => 'This painting shows a single person standing against a soft, textured background. The figure is detailed and clear, with bold lines in black, white, and grey. The background has gentle tones of beige and light blue, creating a calm and peaceful feeling. The painting gives a sense of loneliness but also quiet strength.',
            ],
            [
                'category_name' => 'Figurative',
                'product_name' => 'Graceful Profile',
                'price' => 70,
                'description' => 'This painting shows the side of a woman’s face with soft details and smooth lines. The background is a mix of deep maroon and grassy green, making the face stand out beautifully. The colours and design give the artwork a calm and thoughtful feeling, with just a little abstract style.',
            ],
            [
                'category_name' => 'Figurative',
                'product_name' => 'The Apple Basket',
                'price' => 100,
                'description' => 'This painting shows a basket of apples sitting on a table, with some apples spilling out onto the surface. The apples are bright and colourful, making them stand out against the wooden table. The brushstrokes give it a soft and warm feeling, like a quiet moment in the kitchen or on a farm.',
            ],
            [
                'category_name' => 'Figurative',
                'product_name' => 'Tabletop Harmony',
                'price' => 125,
                'description' => 'This figurative art piece captures a cozy and elegant arrangement of objects on a rustic wooden table. A vintage teapot, a neatly stacked pile of books, and a vase filled with vibrant wildflowers create a warm and inviting composition. The soft brushstrokes and semi-abstract style bring a sense of calm and simplicity, with warm tones of brown, cream, and gold, balanced by the bright blues and greens of the flowers.',
            ],
            // Category 5
            [
                'category_name' => 'Modern',
                'product_name' => 'Golden Night Tree',
                'price' => 50,
                'description' => 'This artwork shows a stunning tree at night, with real golden lights glowing on its leaves. The tree sparkles beautifully under a dark blue sky, creating a magical and peaceful feeling. The soft light highlights the tree’s branches, making it stand out as the centrepiece of the scene.',
            ],
            [
                'category_name' => 'Modern',
                'product_name' => 'Soft Marble Smoke',
                'price' => 75,
                'description' => 'This painting shows a marble-like design with soft swirls of white, grey, and beige, with just a touch of gold on a black background. The gold details are subtle, adding a hint of elegance while keeping the look calm and smooth. The flowing patterns create a peaceful and stylish vibe.',
            ],
            [
                'category_name' => 'Modern',
                'product_name' => 'Two Moons',
                'price' => 60,
                'description' => 'This painting shows two simple full circles, one in dark orange and the other in black, placed on a soft grey background. The design is clean and modern, with a calm and balanced look. It’s minimalist but still stands out, perfect for a cool and stylish space.',
            ],
            [
                'category_name' => 'Modern',
                'product_name' => 'Black Wave',
                'price' => 90,
                'description' => 'This modern black painting has straight textured lines in the background and a smooth wave in the center. The contrast between the wave and the background makes it bold and stylish, perfect for a sleek, modern space.',
            ],
            [
                'category_name' => 'Modern',
                'product_name' => 'Midnight Shape',
                'price' => 50,
                'description' => 'This painting has a clean and simple design with dark colours like black, charcoal, and navy blue. It shows a big rectangle in the middle, giving it a balanced and modern look. The smooth background makes it feel calm and stylish, perfect for a minimalist space.',
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
         * cart dummy data
         */
        $carts = [
            [
                'user_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 57,
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'quantity' => 2,
                'price' => 40,
            ],
        ];
        foreach($carts as $cartData) {
            Cart::firstOrCreate($cartData);
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
