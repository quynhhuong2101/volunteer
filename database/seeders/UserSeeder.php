<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tài khoản Admin
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Quản Trị Viên',
                'password' => Hash::make('password123'),
                'role' => UserRole::ADMIN->value ?? 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 2. Tài khoản Organizer (Tổ chức)
        User::updateOrCreate(
            ['email' => 'organizer@email.com'],
            [
                'name' => 'Đoàn Thanh Niên',
                'password' => Hash::make('password123'),
                'role' => UserRole::ORGANIZER->value ?? 'organizer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'clbtinhnguyen@email.com'],
            [
                'name' => 'CLB Tình nguyện Học viện',
                'password' => Hash::make('password123'),
                'role' => UserRole::ORGANIZER->value ?? 'organizer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 3. Tài khoản Student (Sinh viên)
        $students = [
            ['name' => 'Nguyễn Văn An', 'email' => 'student1@email.com'],
            ['name' => 'Trần Thị Bích', 'email' => 'student2@email.com'],
            ['name' => 'Lê Văn Cường', 'email' => 'student3@email.com'],
            ['name' => 'Phạm Thị Dung', 'email' => 'student4@email.com'],
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'name' => $student['name'],
                    'password' => Hash::make('password123'),
                    'role' => UserRole::STUDENT->value ?? 'student',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Tạo seeder các tài khoản thành công! Mật khẩu chung là: password123');
    }
}
