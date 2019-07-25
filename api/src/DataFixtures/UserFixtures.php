<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('username');
        $user->setEmail('email@email.com');
        $user->setEnabled(true);
        $user->setPlainPassword('123');
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $manager->persist($user);

        for ($i = 1; $i <= 20; ++$i) {
            $user = new User();
            $user->setUsername('username_'.$i);
            $user->setEmail('email'.$i.'@domain.com');
            $user->setEnabled(true);
            $user->setPlainPassword('password');
            $user->setRoles(array('ROLE_ADMIN'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

