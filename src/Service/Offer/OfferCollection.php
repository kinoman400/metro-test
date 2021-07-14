<?php

declare(strict_types=1);

namespace App\Service\Offer;

use App\Service\Offer\Model\PriceRange;
use ArrayIterator;
use InvalidArgumentException;
use Iterator;

class OfferCollection implements OfferCollectionInterface
{
    /**
     * @var OfferInterface[]
     */
    private array $offers;

    public function __construct(array $offers)
    {
        foreach ($offers as $offer) {
            if (!$offer instanceof OfferInterface) {
                throw new InvalidArgumentException('Array should contains only offers');
            }
        }

        $this->offers = $offers;
    }

    public function get(int $index): ?OfferInterface
    {
        return $this->offers[$index] ?? null;
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->offers);
    }

    public function countByPriceRange(PriceRange $priceRange): int
    {
        $count = 0;

        foreach ($this->offers as $offer) {
            if ($priceRange->inRange($offer->getPrice())) {
                $count++;
            }
        }

        return $count;
    }

    public function countByVendorId(int $vendorId): int
    {
        $count = 0;

        foreach ($this->offers as $offer) {
            if ($vendorId === $offer->getVendorId()) {
                $count++;
            }
        }

        return $count;
    }
}
