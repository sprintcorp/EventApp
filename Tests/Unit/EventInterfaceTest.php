<?php

namespace App\Tests\Unit;

use App\Interfaces\EventInterface;
use PHPUnit\Framework\TestCase;

class EventInterfaceTest extends TestCase
{
    protected $eventInterface;

    protected function setUp(): void
    {
        $this->eventInterface = $this->getMockBuilder(EventInterface::class)
            ->getMockForAbstractClass();
    }

    public function testSearchByTermAndDate()
    {
        $term = 'foo';
        $date = '2023-06-01';
        $page = 1;
        $perPage = 10;

        $expectedResult = [];
        $this->eventInterface->expects($this->once())
            ->method('searchByTermAndDate')
            ->with($term, $date, $page, $perPage)
            ->willReturn($expectedResult);

        $result = $this->eventInterface->searchByTermAndDate($term, $date, $page, $perPage);

        $this->assertEquals($expectedResult, $result);
    }

    public function testImportEventToDatabase()
    {
        $expectedResult = 'Events saved successfully';
        $this->eventInterface->expects($this->once())
            ->method('importEventToDatabase')
            ->willReturn($expectedResult);

        $result = $this->eventInterface->importEventToDatabase();
       
        $this->assertEquals($expectedResult, $result);
    }
}
