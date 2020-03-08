<?php


namespace Tests;

use Paginator\InterfacePaginator;
use Paginator\InterfaceRepository;
use PHPUnit\Framework\TestCase;
use Paginator\PaginatorBuilder;

class PaginatorIntegrationTest extends TestCase
{
    public function testBasicUsage()
    {
        $builder = new PaginatorBuilder();
        $builder
            ->setElementsPerPage(1)
            ->setInput([3, 1]);

        $result = $builder->paginate(1);

        $this->assertEquals([3], $result->elements());
        $this->assertEquals(1, $result->currentPage());
        $this->assertEquals(2, $result->totalElements());
        $this->assertEquals(1, $result->totalElementsOnCurrentPage());

        $result = $builder->paginate(2);
        $this->assertEquals([1], $result->elements());
    }


    public function testArrayIteratorUsage()
    {
        $builder = new PaginatorBuilder();
        $builder
            ->setElementsPerPage(1)
            ->setInput(new \ArrayIterator([1, 2, 3]));

        $result = $builder->paginate(1);
        $this->assertEquals([1], (array) $result->elements());

        $result = $builder->paginate(2);
        $this->assertEquals([2], (array) $result->elements());

        $result = $builder->paginate(3);
        $this->assertEquals([3], (array) $result->elements());

        $this->assertInstanceOf('ArrayIterator', $result->elements());
    }

    public function testArrayObjectUsage()
    {
        $builder = new PaginatorBuilder();
        $builder
            ->setElementsPerPage(1)
            ->setInput(new \ArrayObject([1, 2, 3]));

        $result = $builder->paginate(1);
        $this->assertEquals([1], (array) $result->elements());

        $result = $builder->paginate(2);
        $this->assertEquals([2], (array) $result->elements());

        $result = $builder->paginate(3);
        $this->assertEquals([3], (array) $result->elements());

        $this->assertInstanceOf('ArrayObject', $result->elements());
    }

    public function testUsingCustomRepository()
    {
        $builder = new PaginatorBuilder();
        $builder
            ->setElementsPerPage(1)
            ->addRepository(new class implements InterfaceRepository {
                public function get(int $start, int $end, array $filters = [], string $sort = InterfacePaginator::SORT_ASC): iterable
                {
                    return [1];
                }
                public function count(array $filters): int
                {
                    return 1;
                }
            });

        $result = $builder->paginate(1);
        $this->assertEquals([1], $result->elements());
    }
}
