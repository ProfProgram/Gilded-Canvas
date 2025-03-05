<?php

namespace App\Enums;

enum UserRole: string
{
    case user = 'user';
    case admin = 'admin';
    case manager = 'manager';
}
