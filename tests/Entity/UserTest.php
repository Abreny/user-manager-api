<?php
namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase {
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = static::$container
            ->get('validator');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->validator = null;
    }

    private function getUser(): User
    {
        return (new User())
            ->setEmail('user@test.io')
            ->setNom('Nom')
            ->setPrenom('Prenom');
    }

    private function assertHasErrors(User $user, $errorExpected = 0)
    {
        $errors = $this->validator->validate($user);
        $this->assertCount($errorExpected, $errors);
    }

    public function testValidUser()
    {
        $this->assertHasErrors($this->getUser(), 0);
    }

    public function testInvaliEmail()
    {
        $this->assertHasErrors($this->getUser()->setEmail('123'), 1);
        $this->assertHasErrors($this->getUser()->setEmail('@test'), 1);
        $this->assertHasErrors($this->getUser()->setEmail('ab@test'), 1);
        $this->assertHasErrors($this->getUser()->setEmail('ab@bd@test'), 1);
        $this->assertHasErrors($this->getUser()->setEmail('x@y.z'), 0);
    }

    public function testInvalidBlankNom()
    {
        $this->assertHasErrors($this->getUser()->setNom(''), 1);
    }

    public function testCodeRequiredAttributes()
    {
        $this->assertHasErrors(new User(), 2);
    }
}