<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\User;

class CustomApiTestCase extends ApiTestCase
{
    protected function createUser(string $nom,string $email, string $password): User
    {
        $user = new User();
        $user->setNom($nom);
        $user->setMail($email);
        $encoded = self::$container->get('security.user_password_hasher')
            ->encodePassword($user, $password);
        $user->setPassword($encoded);
        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
        return $user;
    }

    protected function logIn(Client $client, string $email, string $password)
    {
        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'mail' => $email,
                'password' => $password
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }

    protected function createUserAndLogIn(Client $client, string $nom, string $email, string $password): User
    {
        $user = $this->createUser($nom, $email, $password);
        $this->logIn($client, $email, $password);
        return $user;
    }
}