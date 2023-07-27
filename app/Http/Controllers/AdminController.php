<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminIndexRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\AdminServices;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use ApiResponser;

    protected $service;
    public function __construct(AdminServices $service)
    {
        $this->service = $service;
    }

    public function index(AdminIndexRequest $request)
    {
        $admins = $this->service->getAllAdmin($request);
        return $this->showPaginate('admins', collect(AdminResource::collection($admins)), collect($admins));
    }

    public function register(AdminRegisterRequest $request)
    {
        $admin = $this->service->createNewAdmin($request);
        return $this->showOne(new AdminResource($admin));
    }

    public function login(AdminLoginRequest $request)
    {
        $token = $this->service->adminLogin($request);
        return $this->showOne($token);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return $this->showOne($token ? true : false);
    }


    public function profile()
    {
        $admin = $this->service->getCurrentAdmin();
        return $this->showOne(new AdminResource($admin));
    }

    public function updateProfile(AdminUpdateRequest $request)
    {
        $status = $this->service->updateAdminProfile($request);
        return $this->showOne($status);
    }

    public function delete()
    {
        $status = $this->service->deleteAccount();
        return $this->showOne($status);
    }
}
