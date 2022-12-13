<?php

namespace App\Tests;

require_once 'vendor/autoload.php';
require_once 'config.php';

use App\Models\User;
use PHPUnit\Framework\TestCase;

class userTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        $this->user = new User;
    }

    public function setDataUserIdProvider(): array
    {
        return [
            [1],
            [2],
            [3]
        ];
    }

    public function testGetUserAll(): void
    {

        $this->user->getAll();
        self::assertIsObject($this->user);
    }
    /**
     * @dataProvider setDataUserIdProvider
     */
    public function testGetUser(int $id): void
    {

        $this->user->get($id);
        self::assertIsObject($this->user);
    }


    public function testCreateUser(): void
    {
        $this->user->id = 2;
        $this->user->name = 'Guillermo';
        $this->user->email = 'emali@mail.com';
        $this->user->password = 'passuno';
        $result = $this->user->create($this->user);

        self::assertArrayHasKey('message', $result);
    }

    public function testUpdateUser(): void
    {
        $this->user->id = 1000;
        $this->user->name = 'update';
        $this->user->email = 'update@mail.com';
        $this->user->password = 'update';
        $result = $this->user->update($this->user);

        self::assertArrayHasKey('message', $result);
    }

    public function testDeleteUser(): void
    {
        $id = 1;
        $result = $this->user->delete($id);

        self::assertArrayHasKey('message', $result);
    }
}
