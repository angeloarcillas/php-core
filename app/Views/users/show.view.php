<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Core - Create user</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="m-12">
        <div class="w-1/3 mx-auto p-6 border rounded-md">
            <div class="text-xs">
                <a href="/php-core/users/<?php echo e($user->id) ?>/edit" class="text-blue-400 hover:text-blue-500">Edit</a>
                <button onclick="document.querySelector('#deleteUser').submit()" class="ml-2 text-red-400 hover:text-red-500">Delete</button>
                <form id="deleteUser" action="/php-core/users/<?php echo e($user->id) ?>" method="POST" class="hidden">
                    <input type="hidden" name="_method" value="DELETE" />
                </form>
            </div>
            <h2 class="text-xl"><?php echo e($user->username) ?></h2>
            <p class="text-gray-700 py-2"><?php echo e($user->email) ?></p>
        </div>
    </div>

</body>

</html>