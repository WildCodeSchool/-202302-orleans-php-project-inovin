<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessFul(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertResponseIsSuccessful('Impossible d\'accéder à l\'url : ' . $url);
    }

    public function urlProvider(): mixed
    {
        yield ['/']; //home page
        yield ['/admin']; //admin home page
        yield ['/contact']; //contact page
        yield ['/login']; //login page
        yield ['/session']; //admin index séance
        yield ['/admin/cepage']; //admin index cépage
        yield ['/vin']; //admin index vin
    }
}
