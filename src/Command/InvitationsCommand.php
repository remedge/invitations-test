<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CityLocation;
use App\DTO\User;
use App\Locator\CityUsersLocator;
use App\Parser\UsersParser;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:invitations')]
class InvitationsCommand extends Command
{
    private const USERS_DATA_FILE_PATH = 'data/affiliates.txt';
    private const CITY_LATITUDE = '53.3340285';
    private const CITY_LONGITUDE = '-6.2535495';
    private const DISTANCE = 100;

    public function __construct(
        private UsersParser $usersParser,
        private CityUsersLocator $cityUsersLocator,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send invitations to users')
            ->setHelp('This command allows you to send invitations to users.')
            ->addArgument('file', InputArgument::OPTIONAL, 'File path to the users data', self::USERS_DATA_FILE_PATH)
            ->addArgument('latitude', InputArgument::OPTIONAL, 'City latitude', self::CITY_LATITUDE)
            ->addArgument('longitude', InputArgument::OPTIONAL, 'City longitude', self::CITY_LONGITUDE)
            ->addArgument('distance', InputArgument::OPTIONAL, 'Distance in km', self::DISTANCE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // create city location
        try {
            $cityLocation = new CityLocation(
                latitude: (string)$input->getArgument('latitude'),
                longitude: (string)$input->getArgument('longitude'),
            );
        } catch (Exception $e) {
            $output->writeln(sprintf('Failed to create city location: %s', $e->getMessage()));
            return Command::FAILURE;
        }

        // parse users data
        try {
            $users = $this->usersParser->parse((string)$input->getArgument('file'));
        } catch (Exception $e) {
            $output->writeln(sprintf('Failed to parse users: %s', $e->getMessage()));
            return Command::FAILURE;
        }

        // find users in the radius of the city
        $locatedUsers = $this->cityUsersLocator->findUsersInRadius(
            cityLocation: $cityLocation,
            distance: (int)$input->getArgument('distance'),
            users: $users
        );

        // sort located users by Affiliate ID (ascending)
        usort($locatedUsers, fn(User $a, User $b) => $a->getAffiliateId() <=> $b->getAffiliateId());

        // output the name and affiliate ID of each located user
        foreach ($locatedUsers as $user) {
            $output->writeln(sprintf('User: %s, AffiliateId: %s', $user->getName(), $user->getAffiliateId()));
        }

        return Command::SUCCESS;
    }
}