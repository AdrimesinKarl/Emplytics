<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case HR = 'hr';
    case Employee = 'employee';
}
