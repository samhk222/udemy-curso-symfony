<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture{
    
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager){
        $this->loadMicroPosts($manager);
        $this->loadUsers($manager);

    }

    private function loadMicroPosts(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $micropost = new Micropost();
            $micropost->setText("Some random text " .rand(1,1000));
            $micropost->setTime(new \DateTime('2018-08-29'));
            $manager->persist($micropost);
        }
        $manager->flush();        
    }
    public function loadUsers(ObjectManager $manager){

        $user = new User();
        $user->setFullname('Marcella Gutierrez');
        $user->setUsername('marcella');
        $user->setEmail('marcella@gmail.com');
        $user->setPassword( $this->passwordEncoder->encodePassword($user, 'marcella') );
        
        $manager->persist( $user );
        $manager->flush();

        $user = new User();
        $user->setFullname('John');
        $user->setUsername('john');
        $user->setEmail('john@gmail.com');
        $user->setPassword( $this->passwordEncoder->encodePassword($user, 'hellojohn') );

        $manager->persist( $user );
        $manager->flush();

    }
}
?>