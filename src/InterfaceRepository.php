<?php

namespace Paginator;

interface InterfaceRepository
{
    public function get(int $start, int $end, array $filters = []);
    public function count(array $filters): int;
}