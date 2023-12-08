<?php

namespace App\Livewire\DashBoard\Chart;

enum FilterType
{
    case TODAY;
    case YESTERDAY;
    case LAST7DAYS;
    case LAST30DAYS;
    case THIS_MONTH;
    case LAST_MONTH;
    case CUSTOM;
}
