<?php

namespace Tests;

use Paginator\InterfaceRepository;
use Paginator\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{

    /**
     * @var InterfaceRepository|MockObject
     */
    private $repository_mock;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository_mock = $this->createMock(InterfaceRepository::class);
    }

   public function testCorrectTotalElementCount()
   {
       $total_count = 74;

       $this->repository_mock
           ->method('totalElements')
           ->willReturn($total_count);

       $paginator = new Paginator($this->repository_mock);
       $result = $paginator->totalElements();
       $this->assertEquals($total_count, $result);
   }
}