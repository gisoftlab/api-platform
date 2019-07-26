<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('username');
        $user->setEmail('email@email.com');
        $user->setIsActive(true);
        $user->setFullname('username');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '123'
        ));

        $manager->persist($user);

        for ($i = 1; $i <= 20; ++$i) {
            $user = new User();
            $user->setUsername('username_'.$i);
            $user->setEmail('email'.$i.'@domain.com');
            $user->setIsActive(true);
            $user->setFullname('username');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $user->setRoles(array('ROLE_ADMIN'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

