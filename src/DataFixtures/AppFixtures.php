<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Collections\ArrayCollection;

class AppFixtures extends Fixture{
    
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager){
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);

    }

    private function loadMicroPosts(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $micropost = new Micropost();
            $micropost->setText("Some random text " .rand(1,1000));
            $micropost->setTime(new \DateTime('2018-08-29'));
            $micropost->setUser( $this->getReference('QualquerNome') );
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
        $user->setFullname('John Doe');
        $user->setUsername('john Doe');
        $user->setEmail('john@gmail.com');
        $user->setPassword( $this->passwordEncoder->encodePassword($user, 'hellojohn') );
        $manager->persist( $user );
        $manager->flush();

        $user = new User();
        $user->setFullname('Samuel Aiala Ferreira');
        $user->setUsername('samhk222');
        $user->setEmail('samuca@samuca.com');
        $user->setPassword( $this->passwordEncoder->encodePassword($user, '123456') );
        $this->addReference('QualquerNome', $user);
        $manager->persist( $user );
        $manager->flush();

        // 44. Fixtures for relations (using references in fixtures)

    }
}
?>