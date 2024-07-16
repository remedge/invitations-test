<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationsControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Invitations');

        // check the table with id users exists
        $this->assertSelectorExists('#users');

        // check the amount of elements with class userinfo
        $this->assertCount(15, $client->getCrawler()->filter('.userinfo'));
    }
}