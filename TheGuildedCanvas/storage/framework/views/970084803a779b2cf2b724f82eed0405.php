<?php $__env->startSection('content'); ?>
<?php
$categoryUnordered = [];
?>
<?php $__currentLoopData = $productInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$categoryUnordered[] = $info->category_name;
?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php
$categories = array_unique($categoryUnordered);
?>
<?php if(session('status')): ?>
<div class="alert">
    <p class="message"><?php echo e(session('status')); ?></p>
    <form method="POST" action="<?php echo e(url('/close-alert')); ?>" style="display: inline;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="close-btn">✖</button>
    </form>
</div>
<?php endif; ?>
<div class="container">
    <div class="product-header">
        <h1>Product Page</h1>
    </div>
    <!-- Product Filtering -->
    <div class="search-container">
    <form action="<?php echo e(route('product-search')); ?>" method="GET">
        <!-- Search by name or category -->
        <input 
            type="text" 
            name="query" 
            placeholder="Search for product names or categories..." 
            value="<?php echo e(request('query')); ?>"
            class="search-input"
        >
        <!-- Choose Category -->
        <select class="category-select" name="category">
            <option value="" disabled 
            <?php if(!request('category')): ?> selected <?php endif; ?>
            hidden>Select a Category</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category); ?>" <?php if(request('category') == $category): ?> selected <?php endif; ?>>
                    <?php echo e($category); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="search-button">Search</button>
    </form>
    </div>

    <?php
        $query = request('query');
        $category = request('category');

        // Filter products based on query and category
        $filteredProducts = $productInfo->filter(function($product) use ($query, $category) {
            $matchesQuery = $query ? stripos($product->product_name, $query) !== false || stripos($product->category_name, $query) !== false : true;
            $matchesCategory = $category ? $product->category_name == $category : true;

            return $matchesQuery && $matchesCategory;
        });
    ?>

    <div class="product-list">
        <?php if($query || $category): ?>
            <h2>Search Results for "<?php echo e($query); ?>" in "<?php echo e($category); ?>" category</h2>
        <?php endif; ?>

        <?php $__empty_1 = true; $__currentLoopData = $filteredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="product">
                <div class="product-image">
                    <img src="<?php echo e(asset('images/products/img-'.$info->product_id.'.png')); ?>" 
                        alt="<?php echo e($info->product_name); ?>" onclick="window.location.href='<?php echo e(url('/product/'.$info->product_name.'')); ?>'">
                </div>
                <div class="prod-page-details">
                    <h2><?php echo e($info->product_name); ?></h2>
                    <p><?php echo e($info->description); ?></p>
                    <p class="product-price">£<?php echo e($info->price); ?>.00</p>
                    <form method="POST" action="<?php echo e(route('cart.add')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($info->product_id); ?>">
                        <input type="hidden" name="product_name" value="<?php echo e($info->product_name); ?>">
                        <input type="hidden" name="product_price" value="<?php echo e($info->price); ?>">
                        <input type="hidden" name="cartQuan_add" value="1">
                        <button type="submit" class="buy-button">Buy Now</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No products found matching your search.</p>
        <?php endif; ?>
    </div>
</div>
<style>
    .product-image {
        position: relative;
    }

    .product-image img {
        transition: opacity 0.3s ease-in-out;
        z-index: 1;
    }

    .product-image:hover img {
        opacity: 0.6;
    }

    .product-image:hover::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        z-index: 0;
        pointer-events: none;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adams\Documents\GitHub\Gilded-Canvas\TheGuildedCanvas\resources\views/product.blade.php ENDPATH**/ ?>