<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @return array
     */
    public function userRegisterActionProvider(): array
    {
        return [
            [
                'user_1',
                'validemail@asdadasdasdadasd.de',
                200,
            ],
            [
                'sh',
                'validemail@asdadasdasdadasd.de',
                400,
            ],
            [
                'user_2',
                'not valid',
                400,
            ],
        ];
    }

    /**
     * @dataProvider userRegisterActionProvider
     */
    public function testUserRegisterAction($username, $email, $httpCode): void
    {
        $client = static::createClient();

        $payload = [
            'username' => $username,
            'email' => $email,
        ];

        $crawler = $client->request(
            'POST',
            '/user/register',
            $payload
        );

        $this->assertEquals($httpCode, $client->getResponse()->getStatusCode());
    }
}
