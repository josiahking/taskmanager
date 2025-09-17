<?php

namespace App\Enums;

enum PriorityEnum : string
{
    case Urgent = "Urgent";
    case High = "High";
    case Medium = "Medium";
    case Low = "Low";
    case Backlog = "Backlog";
}
