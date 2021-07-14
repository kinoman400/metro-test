<?php

namespace App\Service\Offer;

class FakeApiClient implements ApiClientInterface
{
    public function getOffers(): string
    {
        return json_encode(
            [
                [
                    'price' => 22.8,
                    'vendorId' => 2,
                ],
                [
                    'price' => 10.8,
                    'vendorId' => 1,
                ],
                [
                    'price' => 32.8,
                    'vendorId' => 2,
                ],
                [
                    'price' => 42.8,
                    'vendorId' => 3,
                ],
            ]
        );
    }
}
