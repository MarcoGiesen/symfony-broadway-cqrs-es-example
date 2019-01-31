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
                'geheim',
                'validemail@asdadasdasdadasd.de',
                200,
            ],
            [
                'sh',
                'geheim',
                'validemail@asdadasdasdadasd.de',
                400,
            ],
            [
                'user_2',
                'geheim',
                'not valid',
                400,
            ],
        ];
    }

    /**
     * @dataProvider userRegisterActionProvider
     */
    public function testUserRegisterAction(string $username, string $pw, string $email, int $httpCode): void
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
    }

    /**
     * @return array
     */
    public function userChangeEmailProvider(): array
    {
        return [
            [
                'user_1',
                'geheim',
                'validemail@asdadasdasdadasd.de',
                'validemail2@asdadasdasdadasd.de',
                200,
            ],
        ];
    }

    /**
     * @dataProvider userChangeEmailProvider
     */
    public function testChangeEmailAction(
        string $username,
        string $pw,
        string $email,
        string $emailNew,
        int $httpCode
    ): void {
        $client = static::createClient();

        $payload = [
            'username' => $username,
            'password' => $pw,
            'email' => $email,
        ];

        $client->request(
            'POST',
            '/user/register',
            $payload
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $payload = [
            'uuid' => $response['id'],
            'email' => $emailNew,
        ];

        $client->request(
            'POST',
            '/user/changeEmail',
            $payload
        );

        $this->assertEquals($httpCode, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function userChangePasswordProvider(): array
    {
        return [
            [
                'user_1',
                'geheim',
                'validemail@asdadasdasdadasd.de',
                'validemail2@asdadasdasdadasd.de',
                200,
            ],
        ];
    }

    /**
     * @dataProvider userChangePasswordProvider
     */
    public function testChangePasswordAction(
        string $username,
        string $pw,
        string $email,
        string $emailNew,
        int $httpCode
    ): void {
        $client = static::createClient();

        $payload = [
            'username' => $username,
            'password' => $pw,
            'email' => $email,
        ];

        $client->request(
            'POST',
            '/user/register',
            $payload
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $payload = [
            'uuid' => $response['id'],
            'email' => $emailNew,
        ];

        $client->request(
            'POST',
            '/user/changeEmail',
            $payload
        );

        $this->assertEquals($httpCode, $client->getResponse()->getStatusCode());
    }
}
