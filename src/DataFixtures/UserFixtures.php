<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    for ($i = 1; $i <= 100; $i++) {
      $manager->persist((new User())
          ->setNom('Nomuser' . $i)
          ->setPrenom('Prenomuser' . $i)
          ->setEmail("user{$i}@gmail.com")
      );
    }
    $manager->flush();
  }
}
