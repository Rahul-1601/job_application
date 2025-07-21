<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compose Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="p-8 bg-white rounded shadow max-w-lg w-full">
        <h1 class="text-3xl font-bold mb-4">Compose Demo</h1>
        <?php if (session('success')): ?>
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded"><?= session('success') ?></div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded"><?= session('error') ?></div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('compose-demo/save') ?>">
            <?= csrf_field() ?>
            <textarea name="content" class="w-full border rounded p-2 mb-4" rows="4" placeholder="Type your message..."><?= old('content') ?></textarea>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        </form>
    </div>
</body>
</html> 