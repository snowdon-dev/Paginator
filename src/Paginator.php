<?php

namespace Paginator;

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
    private int $pageNo;


    /**
     * Paginator constructor.
     * @param InterfaceRepository   $repository
     * @param int                   $pages          the page to request from the repository
     */
    public function __construct(InterfaceRepository $repository, int $pages = 1)
    {
        $this->repository = $repository;
        $this->filters = [];
        $this->pageNo = $pages;
    }

    public function addFilter($filter)
    {
        $this->filters[] = $filter;
    }

    public function elements(): iterable
    {
        // TODO: Implement elements() method.
    }

    public function currentPage(): int
    {
        // TODO: Implement currentPage() method.
    }

    /**
     * @inheritDoc
     */
    public function pages(): array
    {
        // TODO: Implement pages() method.
    }

    public function totalElements(): int
    {
        return $this->repository->count($this->filters);
    }

    public function totalElementsOnCurrentPage(): int
    {
        // TODO: Implement totalElementsOnCurrentPage() method.
    }

    public function totalElementsPerPage(): int
    {
        // TODO: Implement totalElementsPerPage() method.
    }
}