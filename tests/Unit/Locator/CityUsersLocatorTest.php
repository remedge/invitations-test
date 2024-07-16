<?php

declare(strict_types=1);

namespace App\Tests\Unit\Locator;

use App\DTO\CityLocation;
use App\DTO\User;
use App\Locator\CityUsersLocator;
use PHPUnit\Framework\TestCase;

class CityUsersLocatorTest extends TestCase
{
    public function testFindUsersInRadius(): void
    {
        // Arrange
        $cityLocation = new CityLocation(
            latitude: '53.339428',
            longitude: '-6.257664',
        );
        $distance = 100;
        $users = [
            new User(
                affiliateId: 1,
                name: 'Alice',
                latitude: '53.2451022',
                longitude: '-6.238335',
            ),
            new User(
                affiliateId: 2,
                name: 'Bob',
                latitude: '53.2451022',
                longitude: '-6.238335',
            ),
        ];
        $cityUsersLocator = new CityUsersLocator();

        // Act
        $result = $cityUsersLocator->findUsersInRadius($cityLocation, $distance, $users);

        // Assert
        $this->assertCount(2, $result);
    }

    public function testFindUsersInOuterRadiusWithNoUsers(): void
    {
        // Arrange
        $cityLocation = new CityLocation(
            latitude: '53.339428',
            longitude: '-6.257664',
        );
        $distance = 10;
        $users = [
            new User(
                affiliateId: 1,
                name: 'Alice',
                latitude: '53.2451022',
                longitude: '-6.238335',
            ),
        ];
        $cityUsersLocator = new CityUsersLocator();

        // Act
        $result = $cityUsersLocator->findUsersInRadius($cityLocation, $distance, $users);

        // Assert
        $this->assertCount(0, $result);
    }
}