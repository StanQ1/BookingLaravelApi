<?php

namespace App;

enum UserRoles: string
{
    case CUSTOMER = 'customer';
    case OWNER = 'owner';
    case ADMIN = 'admin';
}
