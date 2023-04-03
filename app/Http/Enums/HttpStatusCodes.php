<?php

namespace App\Http\Enums;

enum HttpStatusCodes: int
{
    case STATUS_OK = 200;
    case STATUS_BAD_REQUEST = 400;
}
