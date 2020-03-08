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
        $tmp_array = (array) $this->getInput();
        $segment = array_splice($tmp_array, $start - 1, $end);
        $valid_map = array_map('is_callable', $filters);

        if (in_array(false, $valid_map)) {
            throw new \InvalidArgumentException('Filter must be a callable');
        }

        foreach($filters as $filter) {
            $segment = array_filter($segment, $filter);
        }

        // @todo implement reflection to sort according to type inference
        sort($segment);

        return $this->returnFactory($segment);
    }

    private function returnFactory($input_segment)
    {
        if ($this->input instanceof \ArrayIterator) {
            return new \ArrayIterator($input_segment);
        }

        if ($this->input instanceof \ArrayObject) {
            return new \ArrayObject($input_segment);
        }

        return $input_segment;
    }

    private function getInput(): iterable
    {
        return $this->input;
    }

    /**
     * @inheritDoc
     */
    public function count(array $filters): int
    {
        return count($this->input);
    }

    public function setInput($input)
    {
        $this->input = $input;
    }
}