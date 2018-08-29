<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture{
    public function load(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $micropost = new Micropost();
            $micropost->setText("Some random text " .rand(1,1000));
            $micropost->setTime(new \DateTime('2018-08-29'));
            $manager->persist($micropost);
        }
        $manager->flush();
    }
}
?>