<?php

declare(strict_types=1);

namespace App\Parser;

use App\DTO\User;
use Exception;

class UsersParser
{
    /**
     * @param string $filePath
     * @return User[]
     * @throws Exception
     */
    public function parse(string $filePath): array
    {
        try {
            $rawContent = file_get_contents($filePath);
        } catch (Exception $e) {
            throw new Exception('Error reading file');
        }

        $rawUsers = explode("\n", $rawContent);
        $users = [];
        foreach ($rawUsers as $value) {
            /** @var array{affiliate_id: int, name: string, latitude: string, longitude: string} $data */
            $data = json_decode($value, true);

            try {
                $user = new User(
                    affiliateId: $data['affiliate_id'],
                    name: $data['name'],
                    latitude: $data['latitude'],
                    longitude: $data['longitude'],
                );
                $users[] = $user;
            } catch (Exception $e) {
                // log the error but continue parsing
            }
        }

        return $users;
    }
}