<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\User;
use Nelmio\Alice\Loader\NativeLoader;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        $loader = new NativeLoader();
        $entities = $loader->loadFile(__DIR__.'/fixtures.yaml')->getObjects();

        foreach ($entities as $entity) {
            if($entity instanceof User) {
                // password decrypt = user
                $entity->setPassword('$argon2id$v=19$m=65536,t=4,p=1$1p0D/j/2PrQKvfxAz/J+SA$NYaUQx44eRoyWtHcww4TjndGeYrqq26aYLZA7tdLMvQ');
            }
            if($entity instanceof Patient && $entity->getGender() == 'f') {
                $entity->setDeath(new \DateTime());d
            }
            $em->persist($entity);
        };

        $em->flush();
    }
}
