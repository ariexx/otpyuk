<?php

namespace App\Repositories;

use App\Http\Resources\ServiceCollection;
use App\Models\Service;

/**
 * Class ServiceRepository.
 */
class ServiceRepository
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $result = $this->model->select([
            'provider_id',
            'service_name',
            'price',
            'is_active',
        ])->whereIsActive(true)->get();
        return new ServiceCollection($result);
    }
}
