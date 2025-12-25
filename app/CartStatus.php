<?php

namespace App;

enum CartStatus: int
{
    case Inactive = 0;

    case Active = 1;

    case Completed = 2;
}
