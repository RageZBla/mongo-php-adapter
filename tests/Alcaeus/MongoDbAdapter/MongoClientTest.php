<?php

namespace Alcaeus\MongoDbAdapter\Tests;

/**
 * @author alcaeus <alcaeus@alcaeus.org>
 */
class MongoClientTest extends TestCase
{
    public function testConnectAndDisconnect()
    {
        $client = $this->getClient();
        $this->assertTrue($client->connected);

        $client->close();
        $this->assertFalse($client->connected);
    }

    public function testClientWithoutAutomaticConnect()
    {
        $client = $this->getClient([]);
        $this->assertFalse($client->connected);
    }

    public function testGetDb()
    {
        $client = $this->getClient();
        $db = $client->selectDB('mongo-php-adapter');
        $this->assertInstanceOf('\MongoDB', $db);
        $this->assertSame('mongo-php-adapter', (string) $db);
    }

    public function testGetDbProperty()
    {
        $client = $this->getClient();
        $db = $client->{'mongo-php-adapter'};
        $this->assertInstanceOf('\MongoDB', $db);
        $this->assertSame('mongo-php-adapter', (string) $db);
    }

    public function testGetCollection()
    {
        $client = $this->getClient();
        $collection = $client->selectCollection('mongo-php-adapter', 'test');
        $this->assertInstanceOf('MongoCollection', $collection);
        $this->assertSame('mongo-php-adapter.test', (string) $collection);
    }

    /**
     * @param array|null $options
     * @return \MongoClient
     */
    protected function getClient($options = null)
    {
        $args = ['mongodb://localhost'];
        if ($options !== null) {
            $args[] = $options;
        }

        $reflection = new \ReflectionClass('MongoClient');

        return $reflection->newInstanceArgs($args);
    }
}
