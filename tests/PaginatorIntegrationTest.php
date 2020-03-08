<?php


namespace Tests;

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
        $input = new \ArrayIterator([1, 2, 3]);

        $builder = new PaginatorBuilder();
        $builder
            ->setElementsPerPage(1)
            ->setInput($input);

        $result = $builder->paginate(1);
        $this->assertEquals([1], $result->elements());

        $result = $builder->paginate(2);
        $this->assertEquals([2], $result->elements());

        $result = $builder->paginate(3);
        $this->assertEquals([3], $result->elements());
    }
}
