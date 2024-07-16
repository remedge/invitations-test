<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CityLocation;
use App\DTO\User;
use App\Locator\CityUsersLocator;
use App\Parser\UsersParser;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class InvitationsController
{
    public function __construct(
        private readonly UsersParser $usersParser,
        private readonly CityUsersLocator $cityUsersLocator,
        private readonly Environment $twig,
    ) {
    }

    private const USERS_DATA_FILE_PATH = __DIR__.'../../../data/affiliates.txt';
    private const CITY_LATITUDE = '53.3340285';
    private const CITY_LONGITUDE = '-6.2535495';
    private const DISTANCE = 100;

    #[Route('/', name: 'invitations')]
    public function index(): Response
    {
        $cityLocation = new CityLocation(
            latitude: self::CITY_LATITUDE,
            longitude: self::CITY_LONGITUDE,
        );

        // parse users data
        try {
            $users = $this->usersParser->parse(self::USERS_DATA_FILE_PATH);
        } catch (Exception $e) {
            throw new Exception(sprintf('Failed to parse users data: %s', $e->getMessage()));
        }

        // find users in the radius of the city
        $locatedUsers = $this->cityUsersLocator->findUsersInRadius(
            cityLocation: $cityLocation,
            distance: self::DISTANCE,
            users: $users
        );

        // sort located users by Affiliate ID (ascending)
        usort($locatedUsers, fn(User $a, User $b) => $a->getAffiliateId() <=> $b->getAffiliateId());

        return new Response($this->twig->render('invitations.html.twig', [
            'users' => $locatedUsers,
        ]));
    }
}