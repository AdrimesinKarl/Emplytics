<?php

namespace App;

enum Role: string
{
    case ADMIN = 'admin';
    case HR = 'hr';
    case EMPLOYEE = 'employee';
}
