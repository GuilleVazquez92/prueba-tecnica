<?php

namespace App\Tests;

require_once 'vendor/autoload.php';
require_once 'config.php';

use App\Case\UseCase;
use PHPUnit\Framework\TestCase;

class caseTest extends TestCase
{
    private $useCase;

    public function setUp(): void
    {
        $this->useCase = new UseCase;
    }


    public function testUSeCaseUser(): void
    {
        $id = 10;
        $name = 'Guillermo';
        $email = 'emali@mail.com';
        $password = 'passuno';
        $result = $this->useCase->store($id, $name, $email, $password);

        self::assertArrayHasKey('message', $result);
    }
}
