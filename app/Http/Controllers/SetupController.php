<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\User;

use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    public function index()
    {
        return Inertia::render('Setup/Index', ['action' => route('setup.index')]);
    }

    public function finish(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users',
            'name'     => 'required|string|min:1',
            'password' => 'required|confirmed',
        ]);

        if (!$validator->fails()) {
            try {
                $this->createInitialRolesAndPermissionsAndUser($validator->validated());

                return Redirect::route('login');
            } catch (Exception $ex) {
                $validator->getMessageBag()->add('generic', 'Unexpected error while setting things up.');

                Log::error('One or more of the database transactions have failed!', [$ex->getMessage()]);
            }
        }

        return Redirect::route('setup.index')
            ->withErrors($validator->getMessageBag());
    }

    private function createInitialRolesAndPermissionsAndUser(array $data): void
    {
        DB::transaction(function () use ($data) {
            $timestamp = Date::now();

            /** @var Role */
            $adminRole = Role::create(['name' => 'administrator']);
            /** @var Role */
            $userRole = Role::create(['name' => 'user']);

            $siteAdminPermission  = Permission::create(['name' => 'site admin']);
            $superAdminPermission = Permission::create(['name' => 'super admin']);

            $adminRole->givePermissionTo($siteAdminPermission);

            $assignUpTokenPermission  = Permission::create(['name' => 'assign token']);
            $manageAccountsPermission = Permission::create(['name' => 'manage account']);

            $userRole->givePermissionTo($manageAccountsPermission);

            $data['email_verified_at'] = $timestamp;
            $data['password']          = Hash::make($data['password']);
            $data['created_at']        = $timestamp;
            $data['updated_at']        = $timestamp;

            /** @var User */
            $user = User::create($data);

            $user->assignRole($adminRole, $userRole);
            $user->givePermissionTo($superAdminPermission, $assignUpTokenPermission);
        });
    }
}
