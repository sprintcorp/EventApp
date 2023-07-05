<?php

namespace App\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/api/events');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString('data', $client->getResponse()->getContent());
    }
}
