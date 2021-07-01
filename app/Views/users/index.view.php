<?php includes('header') ?>

<div class="flex gap-2">
    <?php foreach ($users as $user) : ?>
        <div class="w-1/5 p-6 border rounded-md">
            <small><?php echo e($user->id) ?></small>
            <h2 class="text-xl"><?php echo e($user->username) ?></h2>
            <p class="text-gray-700"><?php echo e($user->email) ?></p>
        </div>
    <?php endforeach ?>
</div>

<?php includes('footer') ?>