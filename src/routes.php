<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    // Home route - Dashboard
    $app->get('/', function (Request $request, Response $response) {
        ob_start();
        require __DIR__ . '/../views/dashboard.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response;
    });
};
