<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$msg = \App\Models\ChatMessage::latest()->first();

if (!$msg) {
    echo "No messages found.\n";
    exit;
}

echo "ID: " . $msg->id . "\n";
echo "Content: " . $msg->content . "\n";
echo "Type: " . $msg->type . "\n";
echo "Attachments (Raw DB): " . ($msg->getAttributes()['attachments'] ?? 'NULL') . "\n";
echo "Attachments (Casted): " . json_encode($msg->attachments) . "\n";
