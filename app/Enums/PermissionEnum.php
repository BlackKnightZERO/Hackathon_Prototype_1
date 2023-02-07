<?php

namespace App\Enums;

enum PermissionEnum : string {
    case INDEX  = 'Index';
    case VIEW   = 'View';
    case CREATE = 'Create';
    case UPDATE = 'Update';
    case DELETE = 'Delete';
}