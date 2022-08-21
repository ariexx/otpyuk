<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ServiceRepository;

class ServiceService
{
    protected $repo;
    public function __construct(ServiceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll($data)
    {
        //check if api key same as in database
        $user = User::checkApikey($data['apikey']);
        if (!$user) {
            return ResponseJsonError(404, __('not-found', ['name' => 'User']));
        }
        return $this->repo->getAll();
    }
}
