<?php

namespace Paginator;

class PaginatorBuilder
{

    /**
     * Namespace to the php class for the repository.
     *
     * @var string|null
     */
    private ?InterfaceRepository $repository = null;
    /**
     * Collection of filter functions.
     *
     * @var callable[]
     */
    private array $filters = [];
    /**
     * The number of items to display per page.
     *
     * @var int
     */
    private ?int $perPage = null;
    /**
     * The sort direction.
     *
     * @var string
     */
    private ?string $sort = null;
    /**
     * @var iterable
     */
    private ?iterable $input = null;

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

    public function setInput($input): self
    {
        $this->input = $input;
        return $this;
    }
    
    public function paginate(int $page, int $perPage = 0): InterfacePaginator
    {
        $repository = $this->getRepository();

        if ($repository instanceof InterfaceInjectable && isset($this->input)) {
            /** @var InterfaceInjectable $repository */
            $repository->setInput($this->input);
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
        return isset($this->repository) ? $this->repository : new DefaultRepository();
    }
}