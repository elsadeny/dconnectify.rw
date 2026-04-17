<?php

namespace App\Enums;

enum ListingType: string
{
    case Vehicle = 'vehicle';
    case Property = 'property';
    case Job = 'job';
    case Service = 'service';

    public function label(): string
    {
        return match ($this) {
            self::Vehicle => 'Cars',
            self::Property => 'Real Estate',
            self::Job => 'Jobs',
            self::Service => 'Services',
        };
    }
}