<?php

declare(strict_types=1);

namespace App\Infrastructure\MongoDb;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDbManager
{
    private $mongoDbClient;
    private $databaseName;

    public function __construct(Client $mongoDbClient, string $databaseName)
    {
        $this->mongoDbClient = $mongoDbClient;
        $this->databaseName = $databaseName;
    }

    public function collection(string $collectionName): Collection
    {
        return $this->mongoDbClient->selectCollection($this->databaseName, $collectionName);
    }
}
