<?php


namespace App\Tests\Functional;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseLinstingResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;
    public function testCreateCheeseListing()
    {
        $client = self::createClient();
        $client->request('POST', '/api/fromages', [
            'headers' => ['Content-Type' => 'application/json'], // là pour indiquer que les données que nous envoyons seront au format JSON
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUser('Nomena', 'n.raminoheritiana@bolzanoGroup.com', '$2y$13$4LGRkUWCxzV2jSQSoNw9QeT926TnNiu94vk0.uK6CW7Iq3JUF.E/W');
        $this->logIn($client,'n.raminoheritiana@bolzanoGroup.com', 'nomena');


    }
}