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
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        // Request a specific page
        $client->request('GET', $url);
        //var_print($url);
        $this->assertResponseIsSuccessful('Impossible d\'accéder à l\'url : ' . $url);
    }

    public function urlProvider(): mixed
    {
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
                            //return the route to test
                            yield [$pathRoute];
                        }
                    }
                }
            }
        }

        /*
        yield ['/']; //home page
        yield ['/admin/']; //admin home page
        yield ['/contact']; //contact page
        yield ['/login']; //login page
        yield ['/session/']; //admin index séance
        yield ['/admin/cepage/']; //admin index cépage
        yield ['/vin/']; //admin index vin
        */
    }
}
