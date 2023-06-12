<?php

namespace App\Tests\Unit;

use App\Controller\EventController;
use App\Services\EventService;
use App\Validation\EventFilterValidation;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

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
