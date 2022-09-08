<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use InvalidArgumentException;
use Throwable;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function show($id)
    {
        try {
            $result = $this->service->show($id);
        } catch (Exception $e) {
            return ResponseJsonError(404, __('not-found', ['name' => 'User']));
        } catch (InvalidArgumentException $e) {
            return ResponseJsonError(500, $e->getMessage());
        }
        return ResponseJsonSuccess(200, __('messages.success.get', ['name' => 'User']), $result);
    }
}
