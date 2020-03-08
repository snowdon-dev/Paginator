<?php

namespace Paginator;

use Traversable;

class Paginator implements InterfacePaginator
{

    private InterfaceRepository $repository;

    /**
     * @var mixed[]
     */
    private array $filters;

    /**
     * @var int
     */
    private int $perPage;

    /**
     * @var int
     */
    private int $currentPage;

    /**
     * @var string
     */
    private string $sort;

    private ?iterable $currentElements;

    /**
     * Build paginating data structure.
     *
     * @param InterfaceRepository $repository data source
     * @param int $pageSize items per page
     * @param int $page current page number
     * @param mixed[] $filters filters to apply on respective source
     * @param string $sort order to sort respective data
     */
    public function __construct(
        InterfaceRepository $repository,
        int $pageSize,
        int $page = 1,
        array $filters = [],
        string $sort = self::SORT_ASC
    ) {
        if (!$page || !$pageSize)
            throw new \InvalidArgumentException(
                'Paginator ' . $page
                    ? '$pageSize'
                    : '$page'
                    . ' requires: int > 0'
            );

        $this->repository = $repository;
        $this->filters = $filters;
        $this->perPage = $pageSize;
        $this->currentPage = $page;
        $this->sort = $sort;
    }

    /**
     * @inheritDoc
     */
    public function elements(): iterable
    {
        $start = ($this->currentPage() - 1) * $this->perPage + 1;
        return $this->currentElements = $this->repository->get(
            $start,
            $this->perPage,
            $this->filters,
            $this->sort
        );
    }

    /**
     * @inheritDoc
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @inheritDoc
     */
    public function pages(): array
    {
        return range(1, $this->getPageCount());
    }

    /**
     * @inheritDoc
     */
    public function totalElements(): int
    {
        return $this->getCount();
    }

    /**
     * @inheritDoc
     */
    public function totalElementsOnCurrentPage(): int
    {
        if (!empty($this->currentElements)) {
            if (is_array($this->currentElements)) {
                return count($this->currentElements);
            } else if ($this->currentElements instanceof Traversable) {
                return count(iterator_to_array($this->currentElements));
            }
        }
        return $this->isLastPage() ? $this->getSpillOver() : $this->perPage;
    }

    /**
     * @inheritDoc
     */
    public function totalElementsPerPage(): int
    {
        // TODO: Implement totalElementsPerPage() method.
    }

    protected function getPageCount()
    {
        return $this->getCount() / $this->perPage + (bool) $this->getSpillOver();
    }

    protected function isLastPage(): bool
    {
        return $this->currentPage() === count($this->pages());
    }

    protected function getCount(): int
    {
        return $this->repository->count($this->filters);
    }

    protected function getSpillOver(): int
    {
        return $this->getCount() % $this->perPage;
    }
}