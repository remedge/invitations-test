<?php

declare(strict_types=1);

namespace App\Tests\Unit\Parser;

use App\Parser\UsersParser;
use PHPUnit\Framework\TestCase;

class UsersParserTest extends TestCase
{
    public function testParse(): void
    {
        $filePath = __DIR__ . '/../../data/test-affiliates.txt';
        $parser = new UsersParser();
        $users = $parser->parse($filePath);

        $this->assertCount(35, $users);
    }

    public function testUnexistingFile(): void
    {
        $filePath = __DIR__ . '/../../data/unexisting-file.txt';
        $parser = new UsersParser();

        $this->expectExceptionMessage('Error reading file');
        $parser->parse($filePath);
    }



}