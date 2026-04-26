<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $organizerId = DB::table('users')->insertGetId([
            'name' => 'Đoàn Thanh Niên',
            'email' => 'organizer@email.com',
            'password' => Hash::make('12345678'),
            'role' => 'organizer',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Students
        $studentIds = [];
        $students = [
            ['Nguyễn Văn An', 'student1@email.com'],
        ];

        foreach ($students as $student) {
            $studentIds[] = DB::table('users')->insertGetId([
                'name' => $student[0],
                'email' => $student[1],
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Create Events (Linked to Organizer)
        $events = [
            // 1. ACTIVE (Approved & Happening Soon)
            [
                'title' => 'Chiến dịch Mùa Hè Xanh 2026',
                'description' => 'Mùa Hè Xanh là chiến dịch tình nguyện thường niên lớn nhất của sinh viên, nơi các bạn trẻ đóng góp sức mình xây dựng nông thôn mới.',
                'start_time' => now()->addDays(5),
                'end_time' => now()->addDays(35),
                'location' => 'Xã Hòa Bình, Huyện Xuyên Mộc',
                'scope' => 'ngoai_truong',
                'category' => 'Môi trường',
                'image' => 'https://images.unsplash.com/photo-1542601906990-24ccd08d7455?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'approved',
                'max_participants' => 50,
            ],
            // 2. ACTIVE (Approved & Happening Now)
            [
                'title' => 'Hiến máu nhân đạo: Giọt hồng yêu thương',
                'description' => 'Chương trình hiến máu nhân đạo nhằm bổ sung nguồn máu dự trữ cho các bệnh viện.',
                'start_time' => now()->subHours(2),
                'end_time' => now()->addHours(4),
                'location' => 'Sảnh A, Học viện',
                'scope' => 'trong_truong',
                'category' => 'Y tế',
                'image' => 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'approved',
                'max_participants' => 200,
            ],
            // 3. PENDING (Waiting Approval)
            [
                'title' => 'Tập huấn sơ cấp cứu cơ bản',
                'description' => 'Trang bị kỹ năng sơ cứu vết thương, hô hấp nhân tạo cho tình nguyện viên mới.',
                'start_time' => now()->addDays(15),
                'end_time' => now()->addDays(15)->addHours(4),
                'location' => 'Hội trường A',
                'scope' => 'trong_truong',
                'category' => 'Kỹ năng',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'pending', 
                'max_participants' => 30,
            ],
            // 4. ENDED (Completed in the past)
            [
                'title' => 'Dạy tiếng Anh cho trẻ em khó khăn',
                'description' => 'Dạy tiếng Anh giao tiếp cơ bản cho trẻ em tại trung tâm bảo trợ.',
                'start_time' => now()->subMonths(2),
                'end_time' => now()->subMonths(2)->addHours(2),
                'location' => 'Trung tâm bảo trợ xã hội số 3',
                'scope' => 'ngoai_truong',
                'category' => 'Giáo dục',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'ended', // Using 'ended' to test Feedback button
                'max_participants' => 15,
            ],
            // 5. COMPLETED (Similar to Ended)
            [
                'title' => 'Ngày hội Đổi rác lấy cây 2025',
                'description' => 'Chương trình khuyến khích sinh viên thu gom pin cũ, giấy vụn để đổi lấy cây sen đá.',
                'start_time' => now()->subDays(10),
                'end_time' => now()->subDays(10)->addHours(8),
                'location' => 'Sảnh C, Trường Đại học',
                'scope' => 'trong_truong',
                'category' => 'Môi trường',
                'image' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'completed',
                'max_participants' => 100,
            ],
            // 6. CANCELLED
            [
                'title' => 'Chuyến đi rừng Cúc Phương (Bị hủy)',
                'description' => 'Khám phá thiên nhiên và bảo vệ động vật hoang dã. (Đã hủy do thời tiết)',
                'start_time' => now()->addDays(2),
                'end_time' => now()->addDays(3),
                'location' => 'Rừng Cúc Phương',
                'scope' => 'ngoai_truong',
                'category' => 'Môi trường',
                'image' => 'https://images.unsplash.com/photo-1510137600163-2729bc6999a4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'cancelled',
                'max_participants' => 40,
            ],
             // 7. ENDED (Completed recent)
            [
                'title' => 'Dọn dẹp bãi biển Vũng Tàu',
                'description' => 'Ra quân làm sạch bãi biển, tuyên truyền ý thức bảo vệ môi trường biển.',
                'start_time' => now()->subDays(5),
                'end_time' => now()->subDays(5)->addHours(4),
                'location' => 'Bãi Sau, Vũng Tàu',
                'scope' => 'ngoai_truong',
                'category' => 'Môi trường',
                'image' => 'https://images.unsplash.com/photo-1618477461853-5f8dd373f9a8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'organizer_id' => $organizerId,
                'status' => 'ended',
                'max_participants' => 80,
            ],
        ];

        $eventIds = [];
        foreach ($events as $event) {
            $event['created_at'] = now();
            $event['updated_at'] = now();
            $eventIds[] = DB::table('events')->insertGetId($event);
        }

        // 3. Create Budgets
        foreach ($eventIds as $eventId) {
            DB::table('budgets')->insert([
                'event_id' => $eventId,
                'total_estimated' => rand(5000000, 20000000),
                'total_approved' => rand(5000000, 15000000),
                'total_spent' => rand(0, 5000000),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // 4. Checkins (Random for approved events)
        foreach ($eventIds as $eventId) {
            // Only checkin for some events
            if (rand(0, 1)) {
                foreach ($studentIds as $studentId) {
                    if (rand(0, 1)) { // Random student participation
                        DB::table('checkins')->insert([
                            'user_id' => $studentId,
                            'event_id' => $eventId,
                            'checkin_time' => now()->subHours(rand(1, 5)),
                            'checkout_time' => rand(0, 1) ? now() : null,
                            'is_verified' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
        // 5. Create Event Positions & Chat Rooms
        dump('Step 5: Positions & Chat');
        foreach ($events as $index => $event) {
            $eventId = $eventIds[$index];

            // Positions
            DB::table('event_positions')->insert([
                ['event_id' => $eventId, 'name' => 'Hậu cần', 'quantity' => 10, 'description' => 'Chuẩn bị đồ dùng, thức ăn', 'created_at' => now(), 'updated_at' => now()],
                ['event_id' => $eventId, 'name' => 'Truyền thông', 'quantity' => 5, 'description' => 'Chụp ảnh, viết bài', 'created_at' => now(), 'updated_at' => now()],
                ['event_id' => $eventId, 'name' => 'Y tế', 'quantity' => 2, 'description' => 'Sơ cứu chấn thương', 'created_at' => now(), 'updated_at' => now()],
            ]);

            // Chat Room
            $roomId = DB::table('chat_rooms')->insertGetId([
                'event_id' => $eventId,
                'name' => 'Thảo luận: ' . $event['title'],
                'type' => 'group',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Chat Messages (Sample)
            DB::table('chat_messages')->insert([
                ['chat_room_id' => $roomId, 'user_id' => $organizerId, 'content' => 'Chào mừng các bạn đến với nhóm!', 'created_at' => now(), 'updated_at' => now()],
                ['chat_room_id' => $roomId, 'user_id' => $studentIds[0], 'content' => 'Em xin chào mọi người ạ.', 'created_at' => now()->addMinute(), 'updated_at' => now()->addMinute()],
            ]);
        }

        // 6. Notifications (Sample)
        dump('Step 6: Notifications');
        foreach ($studentIds as $studentId) {
            DB::table('notifications_table')->insert([
                'user_id' => $studentId,
                'title' => 'Chào mừng bạn mới',
                'message' => 'Chào mừng bạn gia nhập hệ thống tình nguyện!',
                'type' => 'info',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. Forms & Questions (Recruitment)
        try {
            echo "Step 7: Forms\n";
            foreach ($eventIds as $eventId) {
                $formId = DB::table('forms')->insertGetId([
                    'event_id' => $eventId,
                    'title' => 'Đơn đăng ký tình nguyện viên',
                    'description' => 'Vui lòng điền đầy đủ thông tin để tham gia chiến dịch.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('form_questions')->insert([
                    ['form_id' => $formId, 'type' => 'text', 'question' => 'Họ và tên', 'is_required' => true, 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
                    ['form_id' => $formId, 'type' => 'text', 'question' => 'Mã sinh viên', 'is_required' => true, 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
                    ['form_id' => $formId, 'type' => 'text', 'question' => 'Lớp / Khoa', 'is_required' => true, 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
                    ['form_id' => $formId, 'type' => 'textarea', 'question' => 'Tại sao bạn muốn tham gia sự kiện này?', 'is_required' => true, 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
                    ['form_id' => $formId, 'type' => 'radio', 'question' => 'Bạn đã từng tham gia TNV chưa?', 'options' => json_encode(['Rồi', 'Chưa']), 'is_required' => true, 'order' => 5, 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        } catch (\Exception $e) {
            echo 'Error seeding Forms: ' . $e->getMessage() . "\n";
        }

        // 8. Registrations & Reviews
        try {
            echo "Step 8: Registrations\n";
            foreach ($studentIds as $studentId) {
                // Register for 3 random events
                $randomEvents = collect($eventIds)->random(min(3, count($eventIds)));
                foreach ($randomEvents as $eventId) {
                     // Check if already registered to avoid duplicates if running multiple times (though migrate:fresh clears it)
                     // But random logic might pick same event if distinct is not enforced?
                     // collect()->random() returns distinct items so it's fine.
                    DB::table('registrations')->insert([
                        'user_id' => $studentId,
                        'event_id' => $eventId,
                        'status' => ['pending', 'confirmed', 'rejected'][rand(0, 2)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Review for 1 random event
                $reviewEventId = $eventIds[rand(0, count($eventIds) - 1)];
                DB::table('reviews')->insert([
                    'user_id' => $studentId,
                    'event_id' => $reviewEventId,
                    'rating' => rand(4, 5),
                    'comment' => 'Chương trình rất ý nghĩa, mong sẽ có nhiều hoạt động hơn nữa!',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Certificate (Mock) for 1 event
                 DB::table('certificates')->insert([
                    'user_id' => $studentId,
                    'event_id' => $reviewEventId,
                    'code' => 'CERT-' . now()->year . '-' . str_pad((string)$studentId, 4, '0', STR_PAD_LEFT) . '-' . rand(100, 999), 
                    'issued_at' => now()->subDays(rand(1, 30)),
                    'template_url' => 'default_cert.pdf',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            echo 'Error seeding Registrations/Reviews: ' . $e->getMessage() . "\n";
        }

    }
}
