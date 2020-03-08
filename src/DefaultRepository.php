<?php

namespace Paginator;

class DefaultRepository implements InterfaceRepository, InterfaceInjectable
{
    /**
     * @var mixed
     */
    private iterable $input;

    /**
     * @inheritDoc
     */
    public function get(int $start, int $end, array $filters = [], string $sort = InterfacePaginator::SORT_ASC): iterable
    {
        $segment = array_splice($this->input, $start - 1, $end - 1);

        $valid_map = array_map('is_callable', $filters);
        var_dump($filters);
        if (in_array(false, $valid_map)) {
            throw new \InvalidArgumentException('Filter must be a callable');
        }

        foreach($filters as $filter) {
            $segment = array_filter($segment, $filter);
        }


        // @todo implement reflection to sort according to type inference
        sort($segment);

        return $segment;
    }

    /**
     * @inheritDoc
     */
    public function count(array $filters): int
    {

    }

    public function setInput($input)
    {
        $this->input = $input;
    }
}