<?php

namespace Paginator;

interface InterfacePaginator
{
    public function elements(): iterable;
    public function currentPage(): int;

    /**
     * Return keys for all current pages.
     *
     * @return int[]
     */
    public function pages(): array;

    public function totalElements(): int;

    public function totalElementsOnCurrentPage(): int;

    public function totalElementsPerPage(): int;
}
