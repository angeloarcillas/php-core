<?php includes('header') ?>

<div class="w-1/3 mx-auto p-6 border rounded-md">
    <div class="mb-6">
        <h2 class="text-4xl font-bold">Create User</h2>
    </div>
    <form action="/php-core/users" method="POST">
        <div class="mb-6">
            <label for="username" class="block mb-1 text-sm font-bold text-gray-500">Username</label>
            <input type="text" name="username" placeholder="Username..." id="username" class="w-full p-2 border rounded">
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-1 text-sm font-bold text-gray-500">Email</label>
            <input type="text" name="email" placeholder="email..." id="email" class="w-full p-2 border rounded">
        </div>
        <div class="mb-6">
            <button class="w-full py-2 px-3 font-bold uppercase text-white bg-blue-400 rounded hover:bg-blue-500">Submit</button>
        </div>
    </form>
</div>

<?php includes('footer') ?>