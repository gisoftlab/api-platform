<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AccountFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; ++$i) {
            $account = new Account();
            $account->setUsername('example_'.$i);
            $account->setIsActive(($i % 2) ? true : false);
            $account->setPassword(md5((new \DateTime())->getTimestamp()));
            $this->addReference('account_'.$i, $account);
            $manager->persist($account);
        }

        $manager->flush();
    }
}

