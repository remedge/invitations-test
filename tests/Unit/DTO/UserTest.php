<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser(): void
    {
        $user = new User(
            affiliateId: 1,
            name: 'John Doe',
            latitude: '37.7749',
            longitude: '-122.4194',
        );

        self::assertEquals(1, $user->getAffiliateId());
        self::assertEquals('John Doe', $user->getName());
        self::assertEquals('37.7749', $user->getLatitude());
        self::assertEquals('-122.4194', $user->getLongitude());
    }

    public function testIncorrectLongitude(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Longitude bad_value is invalid');

        new User(
            affiliateId: 1,
            name: 'John Doe',
            latitude: '37.7749',
            longitude: 'bad_value',
        );
    }

    public function testIncorrectLatitude(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Latitude 100 is invalid');

        new User(
            affiliateId: 1,
            name: 'John Doe',
            latitude: '100',
            longitude: '-122.4194',
        );
    }



}