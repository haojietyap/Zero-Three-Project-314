<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../Entity/UserAccount.php';
require_once __DIR__ . '/../../Controller/createUserAccountController.php';

final class CreateUserAccountControllerTest extends TestCase
{
    public function testCreateUserAccountFailsWhenRequiredFieldsMissing(): void
    {
        $fakeEntity = $this->createMock(UserAccount::class);
        $controller = new createUserAccountController($fakeEntity);

        $result = $controller->createUserAccount('', '', '', '12345', 1);

        $this->assertFalse($result);
    }

    public function testCreateUserAccountFailsWhenEmailAlreadyExists(): void
    {
        $fakeEntity = $this->createMock(UserAccount::class);
        $fakeEntity->method('emailExists')->willReturn(true);

        $controller = new createUserAccountController($fakeEntity);

        $result = $controller->createUserAccount(
            'adminuser',
            'StrongPass123',
            'taken@example.com',
            '12345',
            1
        );

        $this->assertFalse($result);
    }

    public function testCreateUserAccountSucceedsWhenDataValidAndEmailNew(): void
    {
        $fakeEntity = $this->createMock(UserAccount::class);
        $fakeEntity->method('emailExists')->willReturn(false);
        $fakeEntity->method('createUserAccount')->willReturn(true);

        $controller = new createUserAccountController($fakeEntity);

        $result = $controller->createUserAccount(
            'newuser',
            'StrongPass123',
            'new@example.com',
            '12345',
            1
        );

        $this->assertTrue($result);
    }
}
