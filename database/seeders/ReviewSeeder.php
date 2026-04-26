<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Review;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // 1. Get or Create a specific Student User to demo
        // Priority: "Nguyễn Văn An", then any 'student', then ID 1
        $student = User::where('name', 'Nguyễn Văn An')->first() 
                 ?? User::where('role', 'student')->first() 
                 ?? User::find(1);
        
        if (!$student) {
            $this->command->error('No suitable student user found.');
            return;
        }

        $this->command->info('Seeding reviews for student: ' . $student->name);

        // 2. Create "Pending Review" Events (Finished, Attended, No Review)
        $pendingEvents = [
            [
                'title' => 'Chiến dịch Mùa Hè Xanh 2025 - Mặt trận Tỉnh',
                'location' => 'Xã Dak Rwer, Đắk Lắk',
                'start_time' => Carbon::now()->subDays(10),
                'end_time' => Carbon::now()->subDays(2), // Finished 2 days ago
                'description' => 'Tham gia xây dựng đường nông thôn, dạy học cho trẻ em nghèo.',
                'image' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&q=80&w=1000',
            ],
            [
                'title' => 'Hỗ trợ Lễ Trao bằng Tốt nghiệp Đợt 1',
                'location' => 'Hội trường A, Đại học Công Nghệ',
                'start_time' => Carbon::now()->subDays(5),
                'end_time' => Carbon::now()->subHours(5), // Finished 5 hours ago
                'description' => 'Hỗ trợ công tác tổ chức, hướng dẫn phụ huynh và sinh viên.',
                'image' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=1000',
            ]
        ];

        foreach ($pendingEvents as $data) {
            $event = Event::create(array_merge($data, [
                'user_id' => 1, // Created by Admin/Org
                'status' => 'approved',
                'max_participants' => 50
            ]));

            // Register student
            Registration::create([
                'user_id' => $student->id,
                'event_id' => $event->id,
                'status' => 'completed', // important: completed to allow review
                'checked_in_at' => $event->start_time
            ]);
        }

        // 3. Create "Reviewed" Events (History)
        $reviewedEvents = [
            [
                'data' => [
                    'title' => 'Hiến máu tình nguyện - Giọt hồng yêu thương',
                    'location' => 'Sảnh B, Tòa nhà Trung tâm',
                    'start_time' => Carbon::now()->subMonth(),
                    'end_time' => Carbon::now()->subMonth()->addHours(4),
                    'description' => 'Chương trình hiến máu nhân đạo thường niên.',
                    'image' => 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?auto=format&fit=crop&q=80&w=1000',
                ],
                'review' => [
                    'rating' => 5,
                    'comment' => 'Công tác tổ chức rất chuyên nghiệp. Các bạn tình nguyện viên hỗ trợ rất nhiệt tình. Sẽ tham gia lần sau!'
                ]
            ],
            [
                'data' => [
                    'title' => 'Dọn dẹp vệ sinh Khu phố 6',
                    'location' => 'Khu phố 6, Phường Linh Trung',
                    'start_time' => Carbon::now()->subWeeks(3),
                    'end_time' => Carbon::now()->subWeeks(3)->addHours(3),
                    'description' => 'Ra quân dọn dẹp vệ sinh môi trường khu dân cư.',
                    'image' => 'https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&q=80&w=1000',
                ],
                'review' => [
                    'rating' => 4,
                    'comment' => 'Hoạt động ý nghĩa nhưng trời hơi nắng. Nên chuẩn bị thêm nước uống cho TNV.'
                ]
            ]
        ];

        foreach ($reviewedEvents as $item) {
            $event = Event::create(array_merge($item['data'], [
                'user_id' => 1,
                'status' => 'approved',
                'max_participants' => 100
            ]));

            Registration::create([
                'user_id' => $student->id,
                'event_id' => $event->id,
                'status' => 'completed',
                'checked_in_at' => $event->start_time
            ]);

            Review::create([
                'user_id' => $student->id,
                'event_id' => $event->id,
                'rating' => $item['review']['rating'],
                'comment' => $item['review']['comment']
            ]);
        }
        
        $this->command->info('Seeder completed successfully!');
    }
}
