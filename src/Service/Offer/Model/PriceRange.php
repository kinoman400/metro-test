<?php

declare(strict_types=1);

namespace App\Service\Offer\Model;

use InvalidArgumentException;

class PriceRange
{
    private string $min;
    private string $max;
    private int $scale;

    public function __construct(string $min, string $max, int $scale = 2)
    {
        if ($min > $max) {
            throw new InvalidArgumentException('Invalid range');
        }
        $this->min = $min;
        $this->max = $max;
        $this->scale = $scale;
    }

    public function inRange(string $value): bool
    {
        $lessThanOrEqualMax = bccomp($this->max, $value, $this->scale) !== -1;
        $greaterThanOrEqualMin = bccomp($this->min, $value, $this->scale) !== 1;

        return $lessThanOrEqualMax && $greaterThanOrEqualMin;
    }
}
