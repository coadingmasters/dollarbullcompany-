<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('migrate', ['--force' => true]);
echo "Migration Done! ✅ <br>";

$kernel->call('db:seed', [
    '--class' => 'ProductSeeder',
    '--force' => true
]);
echo "Products Added! ✅";