<?php

declare(strict_types=1);

namespace App\Locator;

use App\DTO\CityLocation;
use App\DTO\User;

class CityUsersLocator
{
    /**
     * @param CityLocation $cityLocation
     * @param int $distance
     * @param User[] $users
     * @return User[]
     */
    public function findUsersInRadius(CityLocation $cityLocation, int $distance, array $users): array
    {
        $usersInRadius = [];
        foreach ($users as $user) {
            $distanceBetweenUsers = $this->calculateDistance(
                $cityLocation->getLatitude(),
                $cityLocation->getLongitude(),
                $user->getLatitude(),
                $user->getLongitude()
            );
            if ($distanceBetweenUsers <= $distance) {
                $usersInRadius[] = $user;
            }
        }

        return $usersInRadius;
    }

    private function calculateDistance(string $latitudeFrom, string $longitudeFrom, string $latitudeTo, string $longitudeTo): float
    {
        $latitudeFrom = (float)$latitudeFrom;
        $longitudeFrom = (float)$longitudeFrom;
        $latitudeTo = (float)$latitudeTo;
        $longitudeTo = (float)$longitudeTo;

        $earthRadius = 6371;
        $latitudeFrom = deg2rad($latitudeFrom);
        $longitudeFrom = deg2rad($longitudeFrom);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);
        $latitudeDelta = $latitudeTo - $latitudeFrom;
        $longitudeDelta = $longitudeTo - $longitudeFrom;
        $angle = 2 * asin(sqrt(pow(sin($latitudeDelta / 2), 2) + cos($latitudeFrom) * cos($latitudeTo) * pow(sin($longitudeDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}