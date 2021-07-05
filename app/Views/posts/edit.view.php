<?php includes('header') ?>

<div class="w-1/3 mx-auto p-6 border rounded-md">
    <div class="mb-6">
        <h2 class="text-4xl font-bold">Edit a post</h2>
    </div>
    <form action="/setup/posts/<?php echo e($post->id) ?>" method="POST">
        <input type="hidden" name="_method" value="PUT" />

        <!-- TITLE -->
        <div class="mb-6">
            <label for="title" class="block mb-1 text-sm font-bold text-gray-500">Title</label>
            <input value="<?php echo e($post->title) ?>" type="text" name="title" id="title" class="w-full p-2 border rounded">
        </div>
        
        <!-- BODY -->
        <div class="mb-6">
            <label for="body" class="block mb-1 text-sm font-bold text-gray-500">Body</label>
            <textarea name="body" id="body" rows="10" class="w-full p-2 border rounded resize-none"><?php echo e($post->body) ?></textarea>
        </div>
        
        <div class="mb-6">
            <button class="w-full py-2 px-3 font-bold uppercase text-white bg-blue-400 rounded hover:bg-blue-500">Update</button>
        </div>
    </form>
</div>

<?php includes('footer') ?>