<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use DI\Container;
use Slim\Factory\AppFactory;
use Notioneers\Shared\Notion\NotionEncryption;
use Notioneers\Shared\Notion\NotionDatabaseHelper;
use Notioneers\Shared\Notion\NotionServiceFactory;
use Notioneers\Shared\Notion\NotionCredentialsController;
use Notioneers\Admintool\Controllers\NotionExampleController;

/**
 * NotionIntegrationTest
 *
 * Verifies that Notion API components are properly integrated into admintool
 */
final class NotionIntegrationTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        // Create Container with test configuration
        $this->container = new Container();

        // Register PDO with in-memory SQLite for testing
        $this->container->set('pdo', function () {
            $pdo = new \PDO('sqlite::memory:');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // Create the credentials table
            $sql = file_get_contents(__DIR__ . '/../../shared/components/notion-api/CreateNotionCredentialsTable.sql');
            $pdo->exec($sql);

            return $pdo;
        });

        // Register Notion components
        $this->container->set(NotionEncryption::class, function () {
            return new NotionEncryption();
        });

        $this->container->set(NotionDatabaseHelper::class, function ($c) {
            return new NotionDatabaseHelper(
                $c->get('pdo'),
                $c->get(NotionEncryption::class)
            );
        });

        $this->container->set(NotionServiceFactory::class, function ($c) {
            return new NotionServiceFactory($c->get('pdo'));
        });

        $this->container->set(NotionCredentialsController::class, function ($c) {
            return new NotionCredentialsController(
                $c->get(NotionDatabaseHelper::class),
                $c->get(NotionEncryption::class),
                'admintool'
            );
        });

        $this->container->set(NotionExampleController::class, function ($c) {
            return new NotionExampleController(
                $c->get(NotionServiceFactory::class),
                $c->get(NotionDatabaseHelper::class)
            );
        });

        // Set container for AppFactory
        AppFactory::setContainer($this->container);
    }

    /**
     * Test: NotionEncryption can be resolved from container
     */
    public function testNotionEncryptionIsRegistered(): void
    {
        $encryption = $this->container->get(NotionEncryption::class);
        $this->assertInstanceOf(NotionEncryption::class, $encryption);
    }

    /**
     * Test: NotionDatabaseHelper can be resolved from container
     */
    public function testNotionDatabaseHelperIsRegistered(): void
    {
        $helper = $this->container->get(NotionDatabaseHelper::class);
        $this->assertInstanceOf(NotionDatabaseHelper::class, $helper);
    }

    /**
     * Test: NotionServiceFactory can be resolved from container
     */
    public function testNotionServiceFactoryIsRegistered(): void
    {
        $factory = $this->container->get(NotionServiceFactory::class);
        $this->assertInstanceOf(NotionServiceFactory::class, $factory);
    }

    /**
     * Test: NotionCredentialsController can be resolved from container
     */
    public function testNotionCredentialsControllerIsRegistered(): void
    {
        $controller = $this->container->get(NotionCredentialsController::class);
        $this->assertInstanceOf(NotionCredentialsController::class, $controller);
    }

    /**
     * Test: NotionExampleController can be resolved from container
     */
    public function testNotionExampleControllerIsRegistered(): void
    {
        $controller = $this->container->get(NotionExampleController::class);
        $this->assertInstanceOf(NotionExampleController::class, $controller);
    }

    /**
     * Test: Encryption/decryption roundtrip works
     */
    public function testEncryptionRoundtrip(): void
    {
        $encryption = $this->container->get(NotionEncryption::class);
        $plaintext = 'secret_notion_api_key_12345';

        $encrypted = $encryption->encrypt($plaintext);
        $this->assertNotEquals($plaintext, $encrypted);

        $decrypted = $encryption->decrypt($encrypted);
        $this->assertEquals($plaintext, $decrypted);
    }

    /**
     * Test: Database credentials table is created
     */
    public function testCredentialsTableIsCreated(): void
    {
        $pdo = $this->container->get('pdo');

        // Query to check if table exists
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='notion_credentials'");
        $result = $stmt->fetch();

        $this->assertNotFalse($result, 'notion_credentials table should exist');
        $this->assertEquals('notion_credentials', $result['name']);
    }

    /**
     * Test: Credentials can be stored and retrieved
     */
    public function testStoreAndRetrieveCredentials(): void
    {
        $helper = $this->container->get(NotionDatabaseHelper::class);

        $appName = 'admintool';
        $workspaceId = 'test_workspace_1';
        $apiKey = 'ntn_1234567890abcdef';
        $workspaceName = 'Test Workspace';

        // Store credentials
        $helper->storeCredentials(
            $appName,
            $workspaceId,
            $apiKey,
            $workspaceName
        );

        // Retrieve credentials
        $retrieved = $helper->getCredentials($appName, $workspaceId);

        $this->assertNotNull($retrieved);
        $this->assertEquals($apiKey, $retrieved['api_key']);
        $this->assertEquals($workspaceName, $retrieved['workspace_name']);
    }

    /**
     * Test: Multiple credentials for same app, different workspaces
     */
    public function testMultipleWorkspaceCredentials(): void
    {
        $helper = $this->container->get(NotionDatabaseHelper::class);
        $appName = 'admintool';

        // Store credentials for workspace 1
        $helper->storeCredentials($appName, 'ws_1', 'key_1', 'Workspace 1');

        // Store credentials for workspace 2
        $helper->storeCredentials($appName, 'ws_2', 'key_2', 'Workspace 2');

        // List all credentials
        $credentials = $helper->listCredentials($appName);

        $this->assertCount(2, $credentials);
        $this->assertEquals('Workspace 1', $credentials[0]['workspace_name']);
        $this->assertEquals('Workspace 2', $credentials[1]['workspace_name']);
    }
}
