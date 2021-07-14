<?php

namespace App\Service\Offer;

use App\Service\Offer\Model\PriceRange;
use Iterator;

interface OfferCollectionInterface
{
    public function get(int $index): ?OfferInterface;

    public function getIterator(): Iterator;
    public function countByPriceRange(PriceRange $priceRange): int;
    public function countByVendorId(int $vendorId): int;
}
