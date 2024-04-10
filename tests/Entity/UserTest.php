<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

   //on cree un user
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

//    on recupere les erreurs
    public function getErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        //pour acceder au noyau symfonycasts
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($user);
        $this->assertCount($number, $errors);
    }

//    on compte les erreurs
    public function testValidUserEntity()
    {
        $this->getErrors($this->getEntity(), 2);
//        $this->getErrors($this->getEntity(), 1);
    }
// on crée les erreurs
    public function testInvalidEmail()
    {
        $this->getErrors($this->getEntity()->setEmail('')->setPassword(15), 2);
//        $this->getErrors($this->getEntity()->setEmail('testphp@mail.fr')->setPassword('azerty'), 0);
    }

}
