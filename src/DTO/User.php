<?php

declare(strict_types=1);

namespace App\DTO;

use InvalidArgumentException;

readonly class User
{
    public function __construct(
        public int $affiliateId,
        public string $name,
        public string $latitude,
        public string $longitude,
    ) {
        // check if latitude is valid
        if (!preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $latitude)) {
            throw new InvalidArgumentException(sprintf('Latitude %s is invalid', $latitude));
        }
        // check if longitude is valid
        if (!preg_match('/^[-]?(([0-9]?[0-9]|1[0-7][0-9])\.(\d+))|(180(\.0+)?)$/', $longitude)) {
            throw new InvalidArgumentException(sprintf('Longitude %s is invalid', $longitude));
        }
    }

    public function getAffiliateId(): int
    {
        return $this->affiliateId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}