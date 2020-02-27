<?php

namespace Paginator;

class Paginator implements InterfacePaginator
{

    private InterfaceRepository $repository;

    public function __construct(InterfaceRepository $repository)
    {
        $this->repository = $repository;
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
        return $this->repository->count();
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