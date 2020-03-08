<?php

namespace Paginator;

class PaginatorBuilder
{

    /**
     * Namespace to the php class for the repository.
     *
     * @var string|null
     */
    private ?string $repository = null;

    private array $filters = [];
    /**
     * @var int
     */
    private ?int $perPage = null;
    /**
     * @var string
     */
    private ?string $sort = null;

    public function addRepository(InterfaceRepository $repo): self
    {
        $this->repository = $repo;
        return $this;
    }

    public function addFilter($filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }
    
    public function setElementsPerPage(int $no): self
    {
        $this->perPage = $no;
        return $this;
    }
    
    public function setSort(string $sort): self
    {
        $this->sort = $sort;
        return $this;
    }
    
    public function paginate(int $page, $input = null, int $perPage = 0): InterfacePaginator
    {
        $class = $this->getRepository();
        /** @var InterfaceRepository $repository */
        $repository = new $class;

        if ($repository instanceof InterfaceInjectable && isset($input)) {
            /** @var InterfaceInjectable $repository */
            $repository->setInput($input);
        }

        return new Paginator(
            $repository, 
            0 === $perPage ? $this->perPage : $perPage, 
            $page,
            $this->filters,
            $this->sort ?? ''
        );
    }

    protected function getRepository()
    {
        return isset($this->repository) ? $this->repository : DefaultRepository::class;
    }
}