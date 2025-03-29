<?php

namespace App;

enum RoomStatus: string
{
    case UNRESERVED = 'unreserved';
    case RESERVED = 'reserved';
}
