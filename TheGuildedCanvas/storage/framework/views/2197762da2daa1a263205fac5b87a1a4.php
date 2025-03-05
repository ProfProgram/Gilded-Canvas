<?php $__env->startSection('content'); ?>
<?php if(session('status')): ?>
    <div class="alert">
        <p class="message"><?php echo e(session('status')); ?></p>
        <form method="POST" action="<?php echo e(url('/close-alert')); ?>" style="display: inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
<?php endif; ?>

<main>
    <section class="login-container">
        <h1>Login</h1>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-text">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required />
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
            </div>
            <a href="<?php echo e(route('password.request')); ?>" class="forgot-details">Forgot Details?</a>
            <button type="submit" class="login-btn">Log-In</button>
        </form>
        <div class="signup-prompt">
            <p>Don’t have an account?</p>
            <a href="<?php echo e(url('/sign-up')); ?>" class="signup-link">Sign Up Now</a>
        </div>
    </section>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adams\Documents\GitHub\Gilded-Canvas\TheGuildedCanvas\resources\views/sign-in.blade.php ENDPATH**/ ?>