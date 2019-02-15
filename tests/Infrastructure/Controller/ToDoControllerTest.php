<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ToDoControllerTest extends WebTestCase
{
    /**
     * @return array
     */
    public function addToDoActionActionProvider(): array
    {
        return [
            [
                'user_1',
                'geheim',
                'validemail@asdadasdasdadasd.de',
                'title',
                'description',
                200,
            ],
        ];
    }

    /**
     * @dataProvider addToDoActionActionProvider
     */
    public function testAddToDoAction(string $username, string $pw, string $email, string $title, string $description, int $httpCode): void
    {
        $client = static::createClient();

        $payload = [
            'username' => $username,
            'password' => $pw,
            'email' => $email,
        ];

        $crawler = $client->request(
            'POST',
            '/user/register',
            $payload
        );

        $this->assertEquals($httpCode, $client->getResponse()->getStatusCode());

        $response = json_decode($client->getResponse()->getContent(), true);

        $payload = [
            'userId' => $response['id'],
            'title' => $title,
            'description' => $description,
        ];

        $crawler = $client->request(
            'POST',
            '/todo/add',
            $payload
        );

        $this->assertEquals($httpCode, $client->getResponse()->getStatusCode());
    }
}
