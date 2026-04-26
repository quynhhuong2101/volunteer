<?php

use Illuminate\Contracts\Console\Kernel;
use Database\Seeders\DatabaseSeeder;

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

try {
    echo "Starting Seeder...\n";
    $seeder = new DatabaseSeeder();
    $seeder->run();
    echo "Seeder Completed Successfully!\n";
} catch (\Exception $e) {
    echo "Seeder Failed!\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
