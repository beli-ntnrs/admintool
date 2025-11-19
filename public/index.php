<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;
use Notioneers\Shared\Notion\NotionEncryption;
use Notioneers\Shared\Notion\NotionDatabaseHelper;
use Notioneers\Shared\Notion\NotionServiceFactory;
use Notioneers\Shared\Notion\NotionCredentialsController;
use Notioneers\Admintool\Controllers\NotionExampleController;

require __DIR__ . '/../vendor/autoload.php';

// Create Container
$container = new Container();

// Register PDO
$container->set('pdo', function () {
    $dbPath = getenv('DB_PATH') ?: __DIR__ . '/../data/app.sqlite';
    return new \PDO('sqlite:' . $dbPath);
});

// Register Notion components
$container->set(NotionEncryption::class, function () {
    return new NotionEncryption();
});

$container->set(NotionDatabaseHelper::class, function ($c) {
    return new NotionDatabaseHelper(
        $c->get('pdo'),
        $c->get(NotionEncryption::class)
    );
});

$container->set(NotionServiceFactory::class, function ($c) {
    return new NotionServiceFactory($c->get('pdo'));
});

$container->set(NotionCredentialsController::class, function ($c) {
    return new NotionCredentialsController(
        $c->get(NotionDatabaseHelper::class),
        $c->get(NotionEncryption::class),
        'admintool'
    );
});

$container->set(NotionExampleController::class, function ($c) {
    return new NotionExampleController(
        $c->get(NotionServiceFactory::class),
        $c->get(NotionDatabaseHelper::class)
    );
});

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Register routes
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);

// Run app
$app->run();
