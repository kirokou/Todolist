<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public const ADMIN_REFERENCE = 'ADMIN';
    public const USER_REFERENCE = 'USER';


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {
            $user = new User();
         
            if ($i&1) {
                $user->setUsername('admin'.$i);
                $user->setEmail(strtolower('admin'.$i.'@gmail.com'));
                $user->setPassword($this->encoder->encodePassword($user, 'admin'.$i));
                $user->setRoles(['ROLE_ADMIN']);

                $manager->persist($user);

                //Reference //1-3
                $this->setReference(self::ADMIN_REFERENCE."$i", $user);


            } else {
                $user->setUsername('user'.$i);
                $user->setEmail(strtolower('user'.$i.'@gmail.com'));
                $user->setPassword($this->encoder->encodePassword($user, 'user'.$i));
                $user->setRoles(['ROLE_USER']);

                $manager->persist($user);

                 //Reference //0 2
                 $this->setReference(self::USER_REFERENCE ."$i", $user);
            }   
                 
          
        }

        $manager->flush();
    }
}
