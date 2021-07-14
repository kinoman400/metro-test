<?php

declare(strict_types=1);

namespace App\Service\Offer;

interface ApiClientInterface
{
    /**
     * @return string Encoded offers in the JSON format
     */
    public function getOffers(): string;
}
