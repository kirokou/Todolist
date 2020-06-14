<?php

namespace App\Tests\Traits;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait NeedLogin
{    
    /**
     * @param  mixed $client
     * @param  mixed $user
     * 
     * @return void
     */
    public function logIn (KernelBrowser $client, User $user): void
    {
        $session = $client->getContainer()->get('session');

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    private function getUser (String $username = null)
    {
        //code 606
        $userRepository = static::$container->get(UserRepository::class);
        return $userRepository->findOneBy(['username' => $username]);
    }
}