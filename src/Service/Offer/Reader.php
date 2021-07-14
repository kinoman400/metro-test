<?php

declare(strict_types=1);

namespace App\Service\Offer;

use App\Service\Offer\Model\Offer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Reader implements ReaderInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $input
     *
     * @return OfferCollectionInterface
     */
    public function read(string $input): OfferCollectionInterface
    {
        $offers = $this->serializer->deserialize(
            $input,
            Offer::class . '[]',
            'json',
            [
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
            ]
        );

        return new OfferCollection($offers);
    }
}
