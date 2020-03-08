# Paginator Example


## Usage
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
