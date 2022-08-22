<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $repo;
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function show($id)
    {
        return $this->repo->show($id);
    }
}
