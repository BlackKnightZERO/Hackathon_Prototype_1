<?php

namespace App\Enums;

enum TicketStatusEnum : string {
    case PENDING        = 'Pending';
    case IN_PROGRESS    = 'In Progress';
    case COMPLETED      = 'Completed';
    case QA_PASSED      = 'QA Passed';
    case PROD_READY     = 'Production Ready';
    case IN_PROD        = 'In Production';
}