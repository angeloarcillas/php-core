<?php includes('header') ?>

<div class="w-1/3 p-4 mx-auto border rounded">

    <div class="mb-6">
        <h2 class="text-4xl font-bold">Register Form</h2>
    </div>

    <?php includes('errors')?>

    <form action="/setup/register" method="POST">
        <!-- USERNAME -->
        <div class="mb-6">
            <label for="username" class="block mb-1 text-sm font-bold text-gray-500">Username</label>
            <input type="text" name="username" placeholder="username..." id="username" class="w-full p-2 border rounded">
        </div>

        <!-- EMAIL ADDRESS -->
        <div class="mb-6">
            <label for="email" class="block mb-1 text-sm font-bold text-gray-500">Email</label>
            <input type="text" name="email" placeholder="email address..." id="email" class="w-full p-2 border rounded">
        </div>

        <!-- PASSWORD -->
        <div class="mb-6">
            <label for="password" class="block mb-1 text-sm font-bold text-gray-500">Password</label>
            <input type="password" name="password" placeholder="password..." id="password" class="w-full p-2 border rounded">
        </div>

        <!-- PASSWORD CONFIRMATION -->
        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 text-sm font-bold text-gray-500">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="confirm password..." id="password_confirmation" class="w-full p-2 border rounded">
        </div>

        <div class="mb-6">
            <button class="w-full py-2 px-3 text-white bg-blue-400 rounded hover:bg-blue-500">Register</button>
        </div>
    </form>

</div>

<?php includes('footer') ?>