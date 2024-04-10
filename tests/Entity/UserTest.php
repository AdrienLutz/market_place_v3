<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends TestCase
{
    public function getEntity(): User
    {
        return (new User())
            ->setEmail('phptest@mail.fr')
            ->setPassword('azerty')
            ->setRoles(['ROLE_USER'])
            ->setVerified(true)
            ->setfirstName('phptest')
            ->setlastName('phptest');
        }
    }

    public function getErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        //pour acceder au noyau symfonycasts
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($user);
        $this->assertCount($number, $errors);
    }

    public function testValidUserEntity()
    {
        $this->getErrors($this->getEntity(), 0);
    }

    public function testInvalidEmail()
    {
        $this->getErrors($this->getEntity()->setEmail(444), 2); // Correction de la syntaxe de l'appel à la méthode setEmail
    }

}
