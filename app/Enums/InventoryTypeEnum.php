<?php

namespace App\Enums;

enum InventoryTypeEnum : string {
    case COMPUTER           = 'Computer';
    case LAPTOP             = 'Laptop';
    case MOUSE              = 'Mouse';
    case KEYBOARD           = 'Keyboard';
    case MONITOR            = 'Monitor';
    case HEADPHONE          = 'Headphone';
    case SERVER             = 'Server';
    case PRINTER            = 'Printer';
    case NETWORKING_EQUIPMENT  = 'Networking Equipment';
    case SECURITY_EQUIPMENT = 'Security Equipment';
    case STORAGE_DEVICE     = 'Storage Device';
    case OTHER              = 'Other';
}