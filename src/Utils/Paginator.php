<?php

namespace App\Utils;

use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;

class Paginator
{
    private $total;
    private $lastPage;
    private $items;

    public function paginate($query, $page = 1, $limit = 5): Paginator
    {
        $paginator = new OrmPaginator($query, false);

        $paginator
            ->getQuery()
            ->setFirstResult(abs($limit * ($page - 1)))
            ->setMaxResults($limit);

        $this->total = $paginator->count();
        $this->lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->items = $paginator;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems()
    {
        return $this->items;
    }
}