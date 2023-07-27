<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminServices
{

    public function getAllAdmin($request)
    {
        return Admin::paginate($request->input('page_size', 10));
    }
    public function createNewAdmin($request)
    {
        return Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

    public function adminLogin($request)
    {
        $admin = Admin::where('email', $request->email)->firstOrFail();
        if (Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('Personal Access Token');
            return ['token' => $token->plainTextToken];
        }
        throw new HttpException(401, 'Wrong email or password');
    }

    public function updateAdminProfile($request)
    {
        $data = $request->only('first_name', 'last_name');
        $currentAdmin = $this->getCurrentAdmin();
        $admin = Admin::findOrFail($currentAdmin->id);
        return $admin->update($data);
    }

    public function getCurrentAdmin()
    {
        return auth()->user();
    }

    public function deleteAccount()
    {
        $currentAdmin = $this->getCurrentAdmin();
        $admin = Admin::findOrFail($currentAdmin->id);
        return $admin->delete();
    }
}
