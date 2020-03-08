<?php

namespace Paginator;

interface InterfaceRepository
{
    /**
     * @param int $start
     * @param int $end
     * @param array $filters
     * @param string $sort
     * @return iterable<mixed>
     */
    public function get(
        int $start,
        int $end,
        array $filters = [],
        string $sort = InterfacePaginator::SORT_ASC
    ): iterable;

    /**
     * @param array $filters
     * @return int
     */
    public function count(array $filters): int;
}