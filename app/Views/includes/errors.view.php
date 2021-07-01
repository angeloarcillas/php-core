<?php if ($errors = app('session')->errorBag()) : ?>
    <div class="mb-4 p-2 text-sm text-red-400">
        <ul class="list-inside list-disc">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo e($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>