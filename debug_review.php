<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('name', 'Nguyễn Văn An')->first();

echo "DEBUG INFO:\n";
if (!$user) {
    echo "User 'Nguyễn Văn An' NOT FOUND.\n";
    $firstUser = \App\Models\User::first();
    echo "First User found: " . ($firstUser ? $firstUser->name . " (ID: $firstUser->id)" : "None") . "\n";
} else {
    echo "User Found: " . $user->name . " (ID: " . $user->id . ")\n";
    
    // Check Events
    $events = \App\Models\Event::where('title', 'like', '%Chiến dịch Mùa Hè Xanh%')->get();
    
    $result = [];
    foreach ($events as $event) {
        $reg = \App\Models\Registration::where('user_id', $user->id)->where('event_id', $event->id)->first();
        $review = \App\Models\Review::where('user_id', $user->id)->where('event_id', $event->id)->first();
        
        $result[] = [
            'event_id' => $event->id,
            'end_time' => $event->end_time,
            'is_ended' => \Carbon\Carbon::parse($event->end_time)->isPast() ? 'YES' : 'NO',
            'registration_status' => $reg ? $reg->status : 'MISSING',
            'has_review' => $review ? 'YES' : 'NO'
        ];
    }
    
    echo json_encode($result, JSON_PRETTY_PRINT);
}
