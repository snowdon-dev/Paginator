# Paginator Example


## Usage
  ```php
  use Paginator\PaginatorBuilder;
  
  require './vendor/autoload.php';
  
  $builder = new PaginatorBuilder();
  
  $paginator = $builder->addFilter(function() {
      return true;
  })
      ->setElementsPerPage(1)
      ->paginate(1, [1, 2]);
  
  var_dump($paginator->elements());
  ```
