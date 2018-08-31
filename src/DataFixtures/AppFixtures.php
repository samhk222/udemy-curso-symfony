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

    private const USERS = [
        [
            'username' => 'samhk222',
            'email' => 'samuca@samuca.com',
            'password' => '123456',
            'fullName' => 'Samuel Aiala',
        ],
        [
            'username' => 'john_doe',
            'email' => 'john_doe@doe.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager){
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);

    }

    private function loadMicroPosts(ObjectManager $manager){
        for ($i=0; $i<100; $i++){
            $micropost = new Micropost();
            $micropost->setText(
                self::POST_TEXT[rand(0, count(self::POST_TEXT)-1)]
            );

            $dataPost = new \DateTime('2018-08-29');
            $dataPost->modify("-" .rand(5,30) ." days");

            $micropost->setTime( $dataPost );
            $micropost->setUser( $this->getReference( self::USERS[rand(0, count(self::USERS)-1)]['username'] ) );
            $manager->persist($micropost);
        }
        $manager->flush();        
    }
    public function loadUsers(ObjectManager $manager){

        foreach (self::USERS as $userData){
            $user = new User();
            // echo "<pre>";
            // print_r($userData);
            // echo "</pre>";
            $user->setFullname($userData['fullName']);
            $user->setUsername( $userData['username'] );
            $user->setEmail( $userData['email'] );
            $this->addReference($userData['username'], $user);

            $user->setPassword( $this->passwordEncoder->encodePassword($user, $userData['password']) );
            $manager->persist( $user );
            $manager->flush();
        
        }

    }
}
?>