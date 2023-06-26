<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    //private static ?KernelBrowser $client = null;
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessFul(string $url): void
    {
        //You can call self::ensureKernelShutdown() before creating your client as per the official recommendation.
        //this avoid you are using 2 times static::createClient() and this will boot again the kernel !!
        self::ensureKernelShutdown();

        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', $url);

        //test page response 200 OK
        $this->assertResponseIsSuccessful('Impossible d\'accéder à l\'url : ' . $url);
    }

    public function urlProvider(): mixed
    {
        yield ['/']; //home page
        yield ['/admin/'];
        yield ['/session/'];
        yield ['/session/new'];
        yield ['/vin/'];
        yield ['/vin/new'];
        yield ['/admin/cepage/'];
        yield ['/admin/cepage/new'];
    }
}
