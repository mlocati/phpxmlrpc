<?php

namespace App\Controller;

use PhpXmlRpc\Server;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{
    protected $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    # This single method serves ALL the xml-rpc requests.
    # The configuration for which xml-rpc methods exist and how they are handled is carried out in the Server service
    #[Route('/xmlrpc', name: 'xml_rpc', methods: ['POST'])]
    public function serve(): Response
    {
        $xmlrpcResponse = $this->server->service(null, true);
        $response = new Response($xmlrpcResponse, 200, ['Content-Type' => 'text/xml']);
        // there should be no need to avoid caching since this is only accessed via POST
        return $response;
    }
}
