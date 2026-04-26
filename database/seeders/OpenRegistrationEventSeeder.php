<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpenRegistrationEventSeeder extends Seeder
{
    public function run()
    {
        // Find Organizer
        $organizer = DB::table('users')->where('email', 'organizer@email.com')->first();
        
        if (!$organizer) {
            $organizerId = DB::table('users')->insertGetId([
                'name' => 'Đoàn Thanh Niên',
                'email' => 'organizer@email.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'organizer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $organizerId = $organizer->id;
        }

        // Create Open Event
        $eventId = DB::table('events')->insertGetId([
            'title' => 'Tổng vệ sinh giảng đường chào đón Tân sinh viên',
            'description' => 'Hoạt động dọn dẹp vệ sinh, trang trí khuôn viên trường để chuẩn bị cho lễ khai giảng và chào đón tân sinh viên khóa mới.',
            'start_time' => now()->addDays(3),
            'end_time' => now()->addDays(3)->addHours(5),
            'location' => 'Khuân viên Tòa nhà Center',
            'scope' => 'trong_truong',
            'category' => 'Cộng đồng',
            'image' => 'https://images.unsplash.com/photo-1550989460-0adf9ea622e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'organizer_id' => $organizerId,
            'status' => 'approved',
            'max_participants' => 30, // Limited spots
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add some random checkins (registrations) but kept under limit (e.g., 5)
        // Need student IDs
        $students = DB::table('users')->where('role', 'student')->limit(5)->get();
        
        foreach($students as $student) {
             DB::table('checkins')->insert([
                'user_id' => $student->id,
                'event_id' => $eventId,
                'checkin_time' => now()->subHours(1),
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Open event seeded successfully!');
    }
}
