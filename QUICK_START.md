# Admintool Notion API Quick Start

## 1. Setup

### Generate Encryption Key
```bash
php -r "echo bin2hex(random_bytes(32));"
```

### Add to .env
```
ENCRYPTION_MASTER_KEY=<your-64-char-hex-string>
DB_PATH=../data/app.sqlite
```

### Start Server
```bash
composer start
# Server running at http://localhost:8000
```

## 2. Store Your First Notion API Key

```bash
curl -X POST http://localhost:8000/api/notion/credentials \
  -H "Content-Type: application/json" \
  -d '{
    "workspace_id": "my-workspace-1",
    "api_key": "ntn_YOUR_NOTION_API_KEY_HERE",
    "workspace_name": "My Notion Workspace"
  }'
```

### Response
```json
{
  "success": true,
  "message": "Credentials stored securely",
  "workspace_id": "my-workspace-1",
  "workspace_name": "My Notion Workspace"
}
```

## 3. Test the Connection

```bash
curl -X POST http://localhost:8000/api/notion/credentials/my-workspace-1/test
```

### Response
```json
{
  "success": true,
  "message": "Connection successful",
  "workspace_name": "My Notion Workspace"
}
```

## 4. List Stored Credentials

```bash
curl http://localhost:8000/api/notion/credentials
```

### Response
```json
{
  "success": true,
  "credentials": [
    {
      "id": 1,
      "workspace_id": "my-workspace-1",
      "workspace_name": "My Notion Workspace",
      "is_active": 1,
      "created_at": "2025-11-19 10:30:00",
      "last_used_at": "2025-11-19 10:35:00"
    }
  ]
}
```

## 5. Use NotionService in Your Code

### Example: Query a Database

```php
<?php
// In your controller
use Notioneers\Shared\Notion\NotionServiceFactory;
use Notioneers\Shared\Notion\NotionDatabaseHelper;

class MyController {
    public function __construct(
        private NotionServiceFactory $factory,
        private NotionDatabaseHelper $helper
    ) {}

    public function getData() {
        // Get stored credentials
        $credentials = $this->helper->getCredentials('admintool', 'my-workspace-1');

        // Create Notion service
        $notion = $this->factory->createWithCredentials($credentials);

        // Query database
        $result = $notion->queryDatabase('your-database-id');

        // Process results
        foreach ($result['results'] as $page) {
            echo "Page: " . $page['id'] . "\n";
            // Access properties
            $props = $page['properties'];
        }
    }
}
```

### Example: Create a Page

```php
$credentials = $this->helper->getCredentials('admintool', 'my-workspace-1');
$notion = $this->factory->createWithCredentials($credentials);

$newPage = $notion->createPage('database-id', [
    'Title' => [
        'title' => [
            ['text' => ['content' => 'My New Page']]
        ]
    ],
    'Status' => [
        'status' => ['name' => 'In Progress']
    ],
    'Due Date' => [
        'date' => ['start' => '2025-11-20']
    ]
]);

echo "Created page: " . $newPage['id'];
```

### Example: Get Page Properties

```php
$page = $notion->getPage('page-id');

// Access properties
$title = $page['properties']['Title']['title'][0]['text']['content'] ?? 'Untitled';
$status = $page['properties']['Status']['status']['name'] ?? 'No status';

echo "Title: $title\n";
echo "Status: $status\n";
```

### Example: Search

```php
$results = $notion->search('keyword');

foreach ($results['results'] as $result) {
    echo "Found: " . $result['id'] . "\n";
    echo "Type: " . $result['object'] . "\n";
}
```

## 6. API Examples (Testing Routes)

### Query Example Database
```bash
curl "http://localhost:8000/api/notion/example/query-database?workspace_id=my-workspace-1&database_id=YOUR_DATABASE_ID"
```

### Create Example Page
```bash
curl -X POST http://localhost:8000/api/notion/example/create-page \
  -H "Content-Type: application/json" \
  -d '{
    "workspace_id": "my-workspace-1",
    "database_id": "YOUR_DATABASE_ID",
    "properties": {
      "Name": {
        "title": [
          {"text": {"content": "Test Page from Admintool"}}
        ]
      }
    }
  }'
```

### Get Page Example
```bash
curl "http://localhost:8000/api/notion/example/get-page?workspace_id=my-workspace-1&page_id=YOUR_PAGE_ID"
```

### Search Example
```bash
curl "http://localhost:8000/api/notion/example/search?workspace_id=my-workspace-1&query=my+search"
```

## 7. Error Handling

All Notion API methods throw `NotionApiException` on errors:

```php
use Notioneers\Shared\Notion\NotionApiException;

try {
    $result = $notion->queryDatabase($databaseId);
} catch (NotionApiException $e) {
    // Check if error is retryable
    if ($e->isRetryable()) {
        // Implement retry logic
    }

    // Check if auth error
    if ($e->isAuthError()) {
        // Credentials may be invalid
    }

    // Get user-friendly message
    $message = $e->getUserMessage();

    // Log error
    error_log($e->getMessage());
}
```

## 8. Disable Credentials

```bash
curl -X DELETE http://localhost:8000/api/notion/credentials/my-workspace-1
```

### Response
```json
{
  "success": true,
  "message": "Credentials disabled successfully"
}
```

## Key Features

- **Secure Storage:** API keys encrypted with AES-256-CBC before database storage
- **Multi-Workspace:** Support for multiple Notion workspaces per app
- **Caching:** Automatic response caching with TTL for performance
- **Rate Limiting:** Respects Notion's 60 requests/minute limit
- **Error Handling:** Structured error responses with retry information
- **Audit Trail:** Tracks last API usage timestamp per workspace

## Common Notion Database IDs

Your database IDs are long alphanumeric strings. You can find them:

1. **In URL:** `https://www.notion.so/username/**{database-id}**?v=view-id`
2. **Via API:** Use the search endpoint to find databases
3. **In Dashboard:** When testing via `/api/notion/example/query-database`

## Need Help?

- **Setup Issues:** See `/shared/components/notion-api/SETUP_CHECKLIST.md`
- **API Reference:** See `/shared/components/notion-api/README.md`
- **Integration Guide:** See `/shared/components/notion-api/INTEGRATION_GUIDE.md`
- **Admintool Specifics:** See `/shared/components/notion-api/ADMINTOOL_SETUP.md`

## Troubleshooting

### "ENCRYPTION_MASTER_KEY not set"
- Generate key: `php -r "echo bin2hex(random_bytes(32));"`
- Add to .env: `ENCRYPTION_MASTER_KEY=<your-key>`

### "No credentials found for this workspace"
- Store credentials first: POST `/api/notion/credentials`
- Use correct workspace_id in requests

### "Rate limit exceeded"
- Notion limits 60 requests/minute
- Built-in rate limiter automatically waits
- Check rate limit percentage: `$notion->rateLimiter->getLimitUsagePercent()`

### "Invalid API key"
- Verify key starts with `ntn_`
- Test with POST `/api/notion/credentials/{id}/test`
- Check in Notion: Settings → Integrations → Manage connections

## Performance Tips

1. **Use Caching:** Database queries are cached (5-10 min TTL)
2. **Batch Operations:** Create multiple pages in one request when possible
3. **Filter Results:** Use database filters to reduce response size
4. **Limit Properties:** Only request needed properties
5. **Monitor Rate Limit:** Check percentage before batch operations

---

Ready to integrate Notion? Start with step 2: Store Your First API Key!
