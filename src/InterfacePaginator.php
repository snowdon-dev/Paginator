<?php

namespace Paginator;

interface InterfacePaginator
{

    public const SORT_ASC = 'ASC';

    /**
     * Return elements of current page.
     *
     * @return iterable<mixed>
     */
    public function elements(): iterable;

    public function currentPage(): int;

    /**
     * Return keys of all pages.
     *
     * @return int[]
     */
    public function pages(): array;

    /**
     * Return total number of elements from data source.
     *
     * @return int
     */
    public function totalElements(): int;


    /**
     * Return the total number of elements on this page.
     *
     * @return int
     */
    public function totalElementsOnCurrentPage(): int;

    public function totalElementsPerPage(): int;
}
