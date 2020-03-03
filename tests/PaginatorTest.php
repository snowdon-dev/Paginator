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

       $paginator = new Paginator($this->repository_mock, 10);

       $this->assertEquals($total_count, $paginator->totalElements());
   }

    public function testPagesWillReturnCorrectPageKeys()
    {
        $pageSize = 50;

        $this->repository_mock
            ->method('count')
            ->willReturn(100);

        $paginator = new Paginator($this->repository_mock, $pageSize);

        $keys = $paginator->pages();

        $this->assertCount(2, $keys);
        $this->assertEquals($keys[0], 1);
        $this->assertEquals($keys[1], 2);
    }


    public function testPagesWillReturnCorrectPageKeysUnEven()
    {
        $pageSize = 50;

        $this->repository_mock
            ->method('count')
            ->willReturn(101);

        $paginator = new Paginator($this->repository_mock, $pageSize);

        $keys = $paginator->pages();

        $this->assertCount(3, $keys);
        $this->assertEquals($keys[0], 1);
        $this->assertEquals($keys[1], 2);
        $this->assertEquals($keys[2], 3);
    }

    public function testReturnsPageElements()
    {
        $pageSize = 3;

        $this->repository_mock
            ->method('count')
            ->willReturn(6);

        $returnArray = [0, 1, 2];

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(1, 4, [])
            ->willReturn($returnArray);

        $paginator = new Paginator($this->repository_mock, $pageSize);

        $elements = $paginator->elements();
        $this->assertEquals($returnArray, $elements);
    }

    public function testReturnsPageElementsSecondPage()
    {
        $pageSize = 3;

        $this->repository_mock
            ->method('count')
            ->willReturn(6);

        $returnArray = [3, 4, 5];

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(4, 7, [])
            ->willReturn($returnArray);

        $paginator = new Paginator($this->repository_mock, $pageSize, 2);

        $elements = $paginator->elements();
        $this->assertEquals($returnArray, $elements);
    }

    public function testReturnsPageElementsFourthPage()
    {
        $pageSize = 5;

        $this->repository_mock
            ->method('count')
            ->willReturn(20);

        $returnArr = [16, 17, 18, 19, 20];

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(16, 21, [])
            ->willReturn($returnArr);

        $paginator = new Paginator($this->repository_mock, $pageSize, 4);

        $elements = $paginator->elements();
        $this->assertEquals($returnArr, $elements);
    }

    public function testReturnsPageElementsSpillOver()
    {
        $pageSize = 5;

        $this->repository_mock
            ->method('count')
            ->willReturn(21);

        $returnArr = [21];

        $this->repository_mock
            ->expects($this->once())
            ->method('get')
            ->with(21, 26, [])
            ->willReturn($returnArr);

        $paginator = new Paginator($this->repository_mock, $pageSize, 5);

        $elements = $paginator->elements();
        $this->assertEquals($returnArr, $elements);
    }

    public function testTotalElementsOnCurrentPage()
    {
        $pageSize = 10;
        $currentPage = 3;

        $this->repository_mock
            ->method('count')
            ->willReturn(100);

        $paginator = new Paginator($this->repository_mock, $pageSize, $currentPage);

        $this->assertEquals($pageSize, $paginator->totalElementsOnCurrentPage());
    }

    // test redundant query is not issued
    public function testTotalElementsOnCurrentPageWillNotCallRepositoryCountGivenAPreviousCallToElements()
    {
        $pageSize = 10;
        $currentPage = 3;

        $this->repository_mock
            ->method('get')
            ->willReturn([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $paginator = new Paginator($this->repository_mock, $pageSize, $currentPage);
        $paginator->elements();

        $this->assertEquals( 10, $paginator->totalElementsOnCurrentPage());
    }

    public function testTotalElementsOnSpillOverPage()
    {
        $pageSize = 10;
        $currentPage = 11;

        $this->repository_mock
            ->method('count')
            ->willReturn(109);

        $paginator = new Paginator($this->repository_mock, $pageSize, $currentPage);

        $this->assertEquals(9, $paginator->totalElementsOnCurrentPage());
    }

    public function testElementsWillWorkWithCustomIterableType()
    {
        $output = new \ArrayIterator([1, 2, 3, 4]);
        $pageSize = 4;
        $currentPage = 1;

        $this->repository_mock
            ->method('get')
            ->willReturn($output);

        $paginator = new Paginator($this->repository_mock, $pageSize, $currentPage);

        $this->assertEquals($output, $paginator->elements());
    }
}