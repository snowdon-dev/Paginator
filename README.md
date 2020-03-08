# Paginator Example


## Usage


### Basic
  ```php
<?php
  use Paginator\PaginatorBuilder;
  
  require './vendor/autoload.php';
  
  $builder = new PaginatorBuilder();
  
  $paginator = $builder->addFilter(function() {
      return true;
  })
      ->setElementsPerPage(1)
      ->setInput([1, 2])
      ->paginate(1);
  
  var_dump($paginator->elements());
  ```

### Persistence layer

```php
use Paginator\PaginatorBuilder;
use Paginator\InterfaceRepository;  
require './vendor/autoload.php';
$builder = new PaginatorBuilder();
$builder->addRepository(new class implements InterfaceRepository {
    /**
     * @inheritDoc
     */
    public function get(int $start, int $end, array $filters = [], string $sort = InterfacePaginator::SORT_ASC): iterable
    {
        // return $db->query('SELECT * FROM test WHERE ....');
        return [1];
    }

    /**
     * @inheritDoc
     */
    public function count(array $filters): int
    {
        // return $db->query('SELECT count(id) FROM test WHERE ...
        return 1;
    }
});
```
