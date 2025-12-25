<?php

namespace App;

enum OrderStatus: int {
    case Created = 0;
    case Processing = 1;
    case Completed = 2;
    case Cancelled = 3;
}
