<?php includes('header') ?>

<div class="w-1/3 p-4 mx-auto border rounded">

    <div class="mb-6">
        <h2 class="text-4xl font-bold">Login Form</h2>
    </div>

    <?php includes('errors') ?>

    <form action="/setup/login" method="POST">
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

        <div class="mb-6">
            <button class="w-full py-2 px-3 text-white bg-blue-400 rounded hover:bg-blue-500">Login</button>
        </div>
    </form>

</div>

<?php includes('footer') ?>