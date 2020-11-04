<?php
namespace App\Core;

use App\Core\Helper\LoggerHelper as Logger;
use App\Core\Network\Request;
use App\Core\Network\Response;
use App\Core\Network\Router;
/**
 * @author Sergiu Bugeac <sergiu.a.bugeac@gmail.com>
 * Main app class, the start point of the application.
 * @property array    $routes The array of predefined routes.
 * @property Request  $request
 * @property Response $response
 * @property Router   $router
 */
class App
{
    public Request $request;
    public Response $response;
    public Router $router;
    public array $routes;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($this->request, $this->response);
        Logger::httpRequests();
    }
}
