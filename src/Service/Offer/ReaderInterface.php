<?php

namespace App\Service\Offer;

interface ReaderInterface
{
    public function read(string $input): OfferCollectionInterface;
}
