<?php

declare(strict_types=1);

namespace Notioneers\Admintool\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Notioneers\Shared\Notion\NotionServiceFactory;
use Notioneers\Shared\Notion\NotionDatabaseHelper;
use Notioneers\Shared\Notion\NotionApiException;
use JsonException;

/**
 * NotionExampleController
 *
 * Demonstrates how to use the NotionService for common operations.
 * This controller shows examples of:
 * - Querying databases
 * - Creating pages
 * - Reading page properties
 * - Handling errors
 */
final class NotionExampleController
{
    public function __construct(
        private NotionServiceFactory $serviceFactory,
        private NotionDatabaseHelper $credentialsHelper,
        private string $appName = 'admintool'
    ) {
    }

    /**
     * Example: Query a database from a stored workspace
     *
     * GET /api/notion/example/query-database?workspace_id=ws_123&database_id=db_456
     */
    public function queryDatabase(Request $request, Response $response): Response
    {
        try {
            $params = $request->getQueryParams();
            $workspaceId = $params['workspace_id'] ?? null;
            $databaseId = $params['database_id'] ?? null;

            if (!$workspaceId || !$databaseId) {
                return $this->jsonResponse($response, [
                    'error' => 'Missing required parameters: workspace_id, database_id',
                ], 400);
            }

            // Get stored credentials for this workspace
            $credentials = $this->credentialsHelper->getCredentials(
                $this->appName,
                $workspaceId
            );

            if (!$credentials) {
                return $this->jsonResponse($response, [
                    'error' => 'No credentials found for this workspace',
                ], 404);
            }

            // Create NotionService with the workspace credentials
            $notionService = $this->serviceFactory->createWithCredentials($credentials);

            // Query the database
            $result = $notionService->queryDatabase($databaseId);

            return $this->jsonResponse($response, [
                'success' => true,
                'database_id' => $databaseId,
                'object' => $result['object'] ?? 'database',
                'pages_count' => count($result['results'] ?? []),
                'pages' => array_map(function ($page) {
                    return [
                        'id' => $page['id'] ?? null,
                        'created_time' => $page['created_time'] ?? null,
                        'properties' => $page['properties'] ?? [],
                    ];
                }, $result['results'] ?? []),
            ]);
        } catch (NotionApiException $e) {
            return $this->jsonResponse($response, [
                'error' => $e->getUserMessage(),
                'notion_error' => $e->getMessage(),
                'code' => $e->getCode(),
                'retryable' => $e->isRetryable(),
            ], (int) $e->getCode() ?: 500);
        } catch (Exception $e) {
            return $this->jsonResponse($response, [
                'error' => 'Unexpected error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Example: Create a new page in a database
     *
     * POST /api/notion/example/create-page
     * Body: { workspace_id: "ws_123", database_id: "db_456", properties: {...} }
     */
    public function createPage(Request $request, Response $response): Response
    {
        try {
            $data = $this->getJsonBody($request);

            $workspaceId = $data['workspace_id'] ?? null;
            $databaseId = $data['database_id'] ?? null;
            $properties = $data['properties'] ?? null;

            if (!$workspaceId || !$databaseId || !$properties) {
                return $this->jsonResponse($response, [
                    'error' => 'Missing required fields: workspace_id, database_id, properties',
                ], 400);
            }

            // Get stored credentials
            $credentials = $this->credentialsHelper->getCredentials(
                $this->appName,
                $workspaceId
            );

            if (!$credentials) {
                return $this->jsonResponse($response, [
                    'error' => 'No credentials found for this workspace',
                ], 404);
            }

            // Create NotionService
            $notionService = $this->serviceFactory->createWithCredentials($credentials);

            // Create the page
            $result = $notionService->createPage(
                $databaseId,
                $properties
            );

            return $this->jsonResponse($response, [
                'success' => true,
                'page_id' => $result['id'] ?? null,
                'url' => $result['url'] ?? null,
                'created_time' => $result['created_time'] ?? null,
            ], 201);
        } catch (NotionApiException $e) {
            return $this->jsonResponse($response, [
                'error' => $e->getUserMessage(),
                'notion_error' => $e->getMessage(),
                'code' => $e->getCode(),
                'retryable' => $e->isRetryable(),
            ], (int) $e->getCode() ?: 500);
        } catch (Exception $e) {
            return $this->jsonResponse($response, [
                'error' => 'Unexpected error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Example: Get a page and read its properties
     *
     * GET /api/notion/example/get-page?workspace_id=ws_123&page_id=page_456
     */
    public function getPage(Request $request, Response $response): Response
    {
        try {
            $params = $request->getQueryParams();
            $workspaceId = $params['workspace_id'] ?? null;
            $pageId = $params['page_id'] ?? null;

            if (!$workspaceId || !$pageId) {
                return $this->jsonResponse($response, [
                    'error' => 'Missing required parameters: workspace_id, page_id',
                ], 400);
            }

            // Get stored credentials
            $credentials = $this->credentialsHelper->getCredentials(
                $this->appName,
                $workspaceId
            );

            if (!$credentials) {
                return $this->jsonResponse($response, [
                    'error' => 'No credentials found for this workspace',
                ], 404);
            }

            // Create NotionService
            $notionService = $this->serviceFactory->createWithCredentials($credentials);

            // Get the page
            $page = $notionService->getPage($pageId);

            return $this->jsonResponse($response, [
                'success' => true,
                'page_id' => $page['id'] ?? null,
                'created_time' => $page['created_time'] ?? null,
                'last_edited_time' => $page['last_edited_time'] ?? null,
                'properties' => $page['properties'] ?? [],
            ]);
        } catch (NotionApiException $e) {
            return $this->jsonResponse($response, [
                'error' => $e->getUserMessage(),
                'notion_error' => $e->getMessage(),
                'code' => $e->getCode(),
                'retryable' => $e->isRetryable(),
            ], (int) $e->getCode() ?: 500);
        } catch (Exception $e) {
            return $this->jsonResponse($response, [
                'error' => 'Unexpected error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Example: Search for content across workspaces
     *
     * GET /api/notion/example/search?workspace_id=ws_123&query=my+search+term
     */
    public function search(Request $request, Response $response): Response
    {
        try {
            $params = $request->getQueryParams();
            $workspaceId = $params['workspace_id'] ?? null;
            $query = $params['query'] ?? null;

            if (!$workspaceId || !$query) {
                return $this->jsonResponse($response, [
                    'error' => 'Missing required parameters: workspace_id, query',
                ], 400);
            }

            // Get stored credentials
            $credentials = $this->credentialsHelper->getCredentials(
                $this->appName,
                $workspaceId
            );

            if (!$credentials) {
                return $this->jsonResponse($response, [
                    'error' => 'No credentials found for this workspace',
                ], 404);
            }

            // Create NotionService
            $notionService = $this->serviceFactory->createWithCredentials($credentials);

            // Perform search
            $results = $notionService->search($query);

            return $this->jsonResponse($response, [
                'success' => true,
                'query' => $query,
                'results_count' => count($results['results'] ?? []),
                'results' => array_map(function ($result) {
                    return [
                        'id' => $result['id'] ?? null,
                        'object' => $result['object'] ?? null,
                        'type' => $result['object'] ?? null,
                    ];
                }, $results['results'] ?? []),
            ]);
        } catch (NotionApiException $e) {
            return $this->jsonResponse($response, [
                'error' => $e->getUserMessage(),
                'notion_error' => $e->getMessage(),
                'code' => $e->getCode(),
                'retryable' => $e->isRetryable(),
            ], (int) $e->getCode() ?: 500);
        } catch (Exception $e) {
            return $this->jsonResponse($response, [
                'error' => 'Unexpected error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper: Extract JSON body from request
     */
    private function getJsonBody(Request $request): array
    {
        try {
            $body = (string) $request->getBody();
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR) ?? [];
        } catch (JsonException) {
            return [];
        }
    }

    /**
     * Helper: Return JSON response
     */
    private function jsonResponse(Response $response, array $data, int $statusCode = 200): Response
    {
        $response = $response->withStatus($statusCode);
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
