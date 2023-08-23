<?php

namespace App\Enums;

enum ApproveStatusEnum : string {
    case APPROVED       = 'Approved';
    case NOT_APPROVED   = 'Not Approved';
}