<?php includes('header') ?>

<div class="w-1/3 mx-auto p-6 border rounded-md">
    <div class="text-xs">
        <!-- EDIT -->
        <a href="/setup/posts/<?php echo e($post->id) ?>/edit" class="text-blue-400 hover:text-blue-500">Edit</a>

        <!-- DELTE -->
        <button onclick="document.querySelector('#deleteUser').submit()" class="ml-2 text-red-400 hover:text-red-500">Delete</button>
        <form id="deleteUser" action="/setup/posts/<?php echo e($post->id) ?>" method="POST" class="hidden">
            <input type="hidden" name="_method" value="DELETE" />
        </form>
    </div>

    <!-- POST -->
    <h2 class="text-xl"><?php echo e($post->title) ?></h2>
    <p class="text-gray-700"><?php echo e($post->body) ?></p>
    <p class="text-xs text-gray-400">user: <?php echo e($post->user_id) ?></p>
</div>

<?php includes('footer') ?>