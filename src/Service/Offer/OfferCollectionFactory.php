<?php

declare(strict_types=1);

namespace App\Service\Offer;

class OfferCollectionFactory
{
    private ApiClientInterface $apiClient;
    private ReaderInterface $reader;

    public function __construct(ApiClientInterface $apiClient, ReaderInterface $reader)
    {
        $this->apiClient = $apiClient;
        $this->reader = $reader;
    }

    public function make(): OfferCollectionInterface
    {
        return $this->reader->read($this->apiClient->getOffers());
    }
}
