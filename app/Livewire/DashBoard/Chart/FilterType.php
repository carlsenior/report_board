<?php

namespace App\Livewire\DashBoard\Chart;

enum FilterType
{
    case Today;
    case Yesterday;
    case Last7Days;
    case Last30Days;
    case ThisMonth;
    case LastMonth;
    case Custom;

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        throw new \ValueError("$name is not a valid FilterType");
    }
}
