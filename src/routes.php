<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Notioneers\Shared\Notion\NotionCredentialsController;
use Notioneers\Admintool\Controllers\NotionExampleController;

return function (App $app) {
    // Home route - Dashboard
    $app->get('/', function (Request $request, Response $response) {
        ob_start();
        require __DIR__ . '/../views/dashboard.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response;
    });

    // Notion API Routes
    // List all stored Notion credentials
    $app->get('/api/notion/credentials', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionCredentialsController::class);
        return $controller->list($request, $response);
    });

    // Store new Notion API credential
    $app->post('/api/notion/credentials', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionCredentialsController::class);
        return $controller->store($request, $response);
    });

    // Test Notion API connection
    $app->post('/api/notion/credentials/{workspace_id}/test', function (Request $request, Response $response, array $args) {
        $controller = $app->getContainer()->get(NotionCredentialsController::class);
        return $controller->test($request, $response, $args);
    });

    // Disable (soft delete) Notion credential
    $app->delete('/api/notion/credentials/{workspace_id}', function (Request $request, Response $response, array $args) {
        $controller = $app->getContainer()->get(NotionCredentialsController::class);
        return $controller->delete($request, $response, $args);
    });

    // Notion Example Routes (Demonstrating NotionService usage)
    // Query a database
    $app->get('/api/notion/example/query-database', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionExampleController::class);
        return $controller->queryDatabase($request, $response);
    });

    // Create a new page in a database
    $app->post('/api/notion/example/create-page', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionExampleController::class);
        return $controller->createPage($request, $response);
    });

    // Get a page and read its properties
    $app->get('/api/notion/example/get-page', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionExampleController::class);
        return $controller->getPage($request, $response);
    });

    // Search across Notion workspace
    $app->get('/api/notion/example/search', function (Request $request, Response $response) {
        $controller = $app->getContainer()->get(NotionExampleController::class);
        return $controller->search($request, $response);
    });
};
