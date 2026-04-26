<?php

use App\Models\User;
use App\Models\Event;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Users and Event Counts:\n";
$users = User::all();
foreach ($users as $user) {
    $count = Event::where('organizer_id', $user->id)->count();
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Events: {$count}\n";
}

echo "\nTotal Events in DB: " . Event::count() . "\n";
