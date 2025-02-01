// includes/tests/UserTest.php
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    // Test login dengan kredensial valid
    public function testLoginWithValidCredentials()
    {
        $email = 'user@example.com';
        $password = 'password123';
        
        $this->assertTrue(login($email, $password)); // Fungsi login mengembalikan true jika berhasil
    }

    // Test login dengan kredensial tidak valid
    public function testLoginWithInvalidCredentials()
    {
        $email = 'wronguser@example.com';
        $password = 'wrongpassword';
        
        $this->assertFalse(login($email, $password)); // Fungsi login mengembalikan false jika gagal
    }

    // Test create user
    public function testCreateUser()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123'
        ];

        $this->assertTrue(createUser($userData)); // Fungsi createUser mengembalikan true jika berhasil
    }

    // Test registrasi dengan email yang tidak valid
    public function testInvalidEmailRegistration()
    {
        $userData = [
            'name' => 'Invalid User',
            'email' => 'invalidemail',
            'password' => 'password123'
        ];

        $this->assertFalse(createUser($userData)); // Fungsi createUser harus mengembalikan false jika email invalid
    }
}