<?php

namespace Botble\Ecommerce\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Ecommerce\Repositories\Interfaces\BrandInterface;

class BrandRepository extends RepositoriesAbstract implements BrandInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAll(array $condition = [])
    {
        $data = $this->model
            ->where($condition)
            ->orderBy('is_featured', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();

        $this->resetModel();

        return $data;
    }
}
