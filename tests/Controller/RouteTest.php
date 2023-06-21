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

    public function urlProvider(): array
    {
        return $this->getAppRoutes();
    }

    private function getAppRoutes(): array
    {
        $myAppRoutes = [];
        $forbidenRoutes = ['/verify/email'];
        $router = $this->getContainer()->get('router');
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();

        foreach ($allRoutes as $route => $params) {
            $defaults = $params->getDefaults();
            //check route concerne controller
            if (isset($defaults['_controller'])) {
                //get the path of the route
                $path = $params->getPath();
                $methods = $params->getMethods();
                //replace parameters brakets by value 1 in the route.
                $routeParameters = array("{id}", "{session}", "{vin}", "{login}", "{grape_variety}, {user}");
                $pathRoute = str_replace($routeParameters, '1', $path);
                //check route not contains parameters not replaced in route
                if (!str_contains($pathRoute, '{')) {
                    //skip route where access is for specific roles or only connected user
                    if (!in_array($pathRoute, $forbidenRoutes)) {
                        //check method GET is possible for the route
                        if (in_array("GET", $methods)) {
                            //add the route to array for the test
                            $myAppRoutes[] = [$pathRoute];
                        }
                    }
                }
            }
        }

        return $myAppRoutes;
    }
}
