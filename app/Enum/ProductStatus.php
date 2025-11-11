<?php

namespace App\Enum;

enum ProductStatus
{
    case ACTIVE;
    case DRAFT;
    case OUT_OF_STOCK;

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::DRAFT => 'Draft',
            self::OUT_OF_STOCK => 'Out of Stock',
        };
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }

    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }
}
