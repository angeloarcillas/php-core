<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <title>PHP Core - Create user</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="m-12">
        <div class="flex gap-2">
            <?php foreach ($users as $user) : ?>
                <div class="w-1/5 p-6 border rounded-md">
                    <h2 class="text-xl"><?php echo e($user->username) ?></h2>
                    <p class="text-gray-700"><?php echo e($user->email) ?></p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</body>

</html>