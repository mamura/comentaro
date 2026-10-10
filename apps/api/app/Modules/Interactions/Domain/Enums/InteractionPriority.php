<?php

namespace App\Modules\Interactions\Domain\Enums;

enum InteractionPriority: string
{
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';

    public static function fromRating(int $rating): self
    {
        return match ($rating) {
            1, 2 => self::High,
            3 => self::Medium,
            4, 5 => self::Low,
            default => throw new \InvalidArgumentException('A nota precisa estar entre 1 e 5.'),
        };
    }
}
