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
           ->method('count')
           ->willReturn($total_count);

       $paginator = new Paginator($this->repository_mock);
       $result = $paginator->totalElements();
       $this->assertEquals($total_count, $result);
   }

    public function testPagesWillReturnCorrectPageKeys()
    {
        $pageNo = 2;

        $this->repository_mock
            ->method('count')
            ->willReturn(100);

        $paginator = new Paginator($this->repository_mock, $pageNo);

        $keys = $paginator->pages();

        $this->assertCount(2, $keys);
        $this->assertEquals($keys[0], 1);
        $this->assertEquals($keys[1], 2);
    }


    public function testReturnsPageElements()
    {
        $pageNo = 1;

        $this->repository_mock
            ->expects($this->once())
            ->method('count')
            ->willReturn(6);

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(0, 2, []);

        $paginator = new Paginator($this->repository_mock, $pageNo);

        $elements = $paginator->elements();
        $this->assertEquals([0, 1, 2], $elements);
    }

    public function testReturnsPageElementsSecondPage()
    {
        $pageNo = 2;

        $this->repository_mock
            ->expects($this->once())
            ->method('count')
            ->willReturn(6);

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(3, 5, []);

        $paginator = new Paginator($this->repository_mock, $pageNo);

        $elements = $paginator->elements();
        $this->assertEquals([3, 4, 5], $elements);
    }
}