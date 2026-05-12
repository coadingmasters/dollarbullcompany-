<?php
// DELETE THIS FILE IMMEDIATELY AFTER USE!
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '/home3/dollarbu/dollarbullcompany-/vendor/autoload.php';
$app = require_once '/home3/dollarbu/dollarbullcompany-/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('migrate', ['--force' => true]);
echo "Migration Done! ✅ <br>";
echo "<pre>" . $kernel->output() . "</pre>";

$kernel->call('db:seed', ['--class' => 'AdminUserSeeder', '--force' => true]);
echo "Admin User Done! ✅ <br>";
echo "<pre>" . $kernel->output() . "</pre>";