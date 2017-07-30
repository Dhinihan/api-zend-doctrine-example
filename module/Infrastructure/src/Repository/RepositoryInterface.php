<?php

namespace Infrastructure\Repository;

use Zend\Paginator\Paginator;

interface RepositoryInterface
{
    public function generatePaginator() : Paginator;
}
