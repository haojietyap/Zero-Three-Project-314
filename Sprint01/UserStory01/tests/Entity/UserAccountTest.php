<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../Database.php';
require_once __DIR__ . '/../../Entity/UserAccount.php';

final class UserAccountTest extends TestCase
{
    private PDO $conn;

    protected function setUp(): void
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        // Reset tables safely because of FK login_audit -> users
        $this->conn->exec('SET FOREIGN_KEY_CHECKS=0');
        $this->conn->exec('TRUNCATE TABLE login_audit'); // child table
        $this->conn->exec('TRUNCATE TABLE users');       // parent table
        $this->conn->exec('SET FOREIGN_KEY_CHECKS=1');
    }

    public function testCreateUserAccountInsertsRowAndHashesPassword(): void
    {
        $userAccount = new UserAccount();

        $username = 'testuser';
        $password = 'P@ssw0rd123';
        $email    = 'test@example.com';
        $phone    = '12345678';
        $profile  = 1;

        $result = $userAccount->createUserAccount(
            $username,
            $password,
            $email,
            $phone,
            $profile
        );

        $this->assertTrue($result);

        $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($row);
        $this->assertSame($username, $row['username']);
        $this->assertSame($email, $row['email']);
        $this->assertSame($phone, $row['phone']);
        $this->assertSame('ACTIVE', $row['status']);
        $this->assertTrue(password_verify($password, $row['password_hash']));
    }

    public function testEmailExistsReturnsTrueForExistingEmail(): void
    {
        $userAccount = new UserAccount();

        $userAccount->createUserAccount(
            'anotheruser',
            'Secret123',
            'exists@example.com',
            '99999999',
            1
        );

        $this->assertTrue($userAccount->emailExists('exists@example.com'));
    }

    public function testEmailExistsReturnsFalseForNonExistingEmail(): void
    {
        $userAccount = new UserAccount();

        $this->assertFalse($userAccount->emailExists('nope@example.com'));
    }
}
