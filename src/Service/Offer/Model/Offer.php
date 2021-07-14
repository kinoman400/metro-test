<?php

declare(strict_types=1);

namespace App\Service\Offer\Model;

use App\Service\Offer\OfferInterface;
use InvalidArgumentException;

class Offer implements OfferInterface
{
    private string $price;
    private int $vendorId;

    public function __construct(string $price, int $vendorId)
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException('Price should be numeric');
        }

        $this->price = $price;
        $this->vendorId = $vendorId;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }
}
