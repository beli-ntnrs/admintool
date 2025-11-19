<?php

declare(strict_types=1);

// Load composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Set environment for testing
putenv('ENCRYPTION_MASTER_KEY=test_key_32_bytes_long_minimum_');
