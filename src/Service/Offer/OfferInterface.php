<?php

namespace App\Service\Offer;

interface OfferInterface
{
    public function getPrice(): string;
    public function getVendorId(): int;
}
