<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case APPROVED_AUTHOR = 'approved_author';
    case PENDING_AUTHOR = 'pending_author';
    case VISITOR = 'visitor';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::EDITOR => 'Editor',
            self::APPROVED_AUTHOR => 'Approved Author',
            self::PENDING_AUTHOR => 'Pending Author',
            self::VISITOR => 'Visitor',
        };
    }
}
