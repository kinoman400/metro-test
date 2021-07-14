<?php

namespace App\Tests;

use App\Service\Offer\Model\Offer;
use App\Service\Offer\Model\PriceRange;
use App\Service\Offer\OfferCollection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class OfferCollectionTest extends TestCase
{
    private array $offers;

    protected function setUp(): void
    {
        $this->offers = [
            new Offer('1.5', 1),
            new Offer('2.5', 2),
            new Offer('3.5', 3),
            new Offer('4.5', 4),
            new Offer('5.5', 1),
            new Offer('6.5', 2),
            new Offer('7.5', 3),
        ];

        parent::setUp();
    }

    /**
     * @dataProvider invalidOffersProvider
     */
    public function test_only_offers_is_allowed(array $offers): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OfferCollection($offers);
    }

    public function invalidOffersProvider(): array
    {
        return [
            [
                [
                    'test',
                    new Offer('12.6', 1),
                ],
            ],
            [
                [
                    1,
                    new Offer('12.6', 1),
                ],
            ],
            [
                [
                    new Offer('12.6', 1),
                    1,
                ],
            ],
            [
                [
                    new stdClass(),
                ],
            ],
        ];
    }

    public function test_get_existed_offset()
    {
        $collection = new OfferCollection($this->offers);

        for ($offset = 0; $offset < count($this->offers); $offset++) {
            $this->assertSame($this->offers[$offset], $collection->get($offset));
        }
    }

    public function test_get_not_existed_offset()
    {
        $collection = new OfferCollection($this->offers);

        $this->assertSame(null, $collection->get(count($this->offers)));
    }

    public function test_iterator_contains_correct_offers_number()
    {
        $collection = new OfferCollection($this->offers);

        $this->assertSame(count($this->offers), count(iterator_to_array($collection->getIterator())));
    }

    /**
     * @dataProvider priceRangeProvider
     */
    public function test_count_by_price_range(PriceRange $priceRange, int $count)
    {
        $collection = new OfferCollection($this->offers);

        $this->assertSame($count, $collection->countByPriceRange($priceRange));
    }

    public function priceRangeProvider(): array
    {
        return [
            [new PriceRange('8.23', '9.23'), 0],
            [new PriceRange('1.23', '9.23'), 7],
            [new PriceRange('1.23', '1.5'), 1],
            [new PriceRange('7.5', '8.6'), 1],
            [new PriceRange('7.5', '7.5'), 1],
        ];
    }

    /**
     * @dataProvider vendorIdProvider
     */
    public function test_count_by_vendor_id(int $vendorId, int $count)
    {
        $collection = new OfferCollection($this->offers);

        $this->assertSame($count, $collection->countByVendorId($vendorId));
    }

    public function vendorIdProvider(): array
    {
        return [
            [1, 2],
            [2, 2],
            [3, 2],
            [4, 1],
            [5, 0],
        ];
    }
}
