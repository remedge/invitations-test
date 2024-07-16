<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\CityLocation;
use Generator;
use PHPUnit\Framework\TestCase;

class CityLocationTest extends TestCase
{
    public function testCityLocation(): void
    {
        $cityLocation = new CityLocation(
            '55.7558',
            '37.6176',
        );

        self::assertEquals('55.7558', $cityLocation->getLatitude());
        self::assertEquals('37.6176', $cityLocation->getLongitude());
    }

    /**
     * @dataProvider provideInvalidLatitude
     *
     */
    public function testCityLocationWithInvalidLatitude(string $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Latitude %s is invalid', $value));

        new CityLocation(
            $value,
            '37.6176',
        );
    }

    /**
     * @return Generator
     */
    public function provideInvalidLatitude(): iterable
    {
        yield ['bad_value'];
        yield ['100'];
        yield ['90.1'];
    }

    /**
     * @dataProvider provideInvalidLongitude
     */
    public function testCityLocationWithInvalidLongitude(string $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Longitude %s is invalid', $value));

        new CityLocation(
            '55.7558',
            $value,
        );
    }

    /**
     * @return Generator
     */
    public function provideInvalidLongitude(): iterable
    {
        yield ['bad_value'];
        yield ['200'];
        yield ['180.1'];
    }
}