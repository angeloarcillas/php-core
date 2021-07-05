<?php includes('header') ?>

<div class="mb-6 text-right">
    <a href="/setup/posts/create" class="py-2 px-3 text-sm text-white bg-blue-400 rounded hover:bg-blue-500">Create a post</a>
</div>

<div class="flex gap-2 border-2 min-h-screen">

    <?php if (count($posts) <=  0) : ?>
        <p class="m-auto">No current post.</p>
    <?php endif ?>

    <?php foreach ($posts as $post) : ?>
        <div class="w-1/5 p-6 border rounded-md">
            <small><?php echo e($post->id) ?></small>
            <a href="/setup/posts/<?php echo e($post->id) ?>" class="hover:text-blue-400">
                <h2 class="text-xl underline"><?php echo e($post->title) ?></h2>
            </a>
            <p class="text-gray-700"><?php echo e($post->body) ?></p>
            <p class="text-xs text-gray-400">user: <?php echo e($post->user_id) ?></p>
        </div>
    <?php endforeach ?>
</div>

<?php includes('footer') ?>