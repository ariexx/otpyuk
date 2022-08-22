<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function show($apikey)
    {
        $result = $this->model->getDetails($apikey);
        return new UserResource($result);
    }
}
