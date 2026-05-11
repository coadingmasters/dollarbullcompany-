<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('migrate', ['--force' => true]);
echo "Tables Created! ✅ <br>";

$kernel->call('db:seed', ['--class' => 'CategorySeeder', '--force' => true]);
echo "Categories Added! ✅ <br>";