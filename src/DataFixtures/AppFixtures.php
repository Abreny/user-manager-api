<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class AppFixtures extends Fixture
{
    use FixturesTrait;

    public function load(ObjectManager $manager)
    {
        
    }
}
