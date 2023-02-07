<?php

namespace App\Enums;

enum ModuleEnum : string {
    case DASHBOARD  = 'Dashboard';
    case PROFILE = 'Profile';
    case USER  = 'User';
    case ROLE = 'Role';
    case PERMISSION  = 'Permission';
    case ROLE_PERMISSION  = 'Role-permission';
    case COOPTERM  = 'Coop-term';
    case MINISTRY  = 'Ministry';
}