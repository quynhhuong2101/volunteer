<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case ORGANIZER = 'organizer';
    case STUDENT = 'student';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::ORGANIZER => 'Organization',
            self::STUDENT => 'Student',
        };
    }
}
