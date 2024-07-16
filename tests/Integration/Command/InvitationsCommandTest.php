<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command;

use App\Command\InvitationsCommand;
use App\Locator\CityUsersLocator;
use App\Parser\UsersParser;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class InvitationsCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();

        $application = new Application($kernel);

        $application->add(new InvitationsCommand(
            new UsersParser(),
            new CityUsersLocator(),
        ));

        $command = $application->find('app:invitations');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'file' => __DIR__ . '/../../data/test-affiliates.txt',
            'latitude' => '47.606210',
            'longitude' => '-122.332071',
            'distance' => 100,
        ]);

        $output = $commandTester->getDisplay();

        self::assertSame(
            <<<EOT
            User: Ella Castillo, AffiliateId: 116\n
            EOT, $output);

        self::assertSame(Command::SUCCESS, $commandTester->getStatusCode());
    }
}