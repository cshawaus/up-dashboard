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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    public function index()
    {
        return Inertia::render('Setup/Index', ['action' => route('setup.index')]);
    }

    public function finish(Request $request)
    {
        $standardError = $status = false;

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users',
            'name'     => 'required|string|min:1',
            'password' => 'required|confirmed',
        ]);

        if (!$validator->fails()) {
            try {
                $this->createInitialRolesAndPermissionsAndUser($validator->validated());

                $status = true;
            } catch (Exception $ex) {
                $standardError = 'Unexpected error while setting things up!';

                Log::error($standardError, [
                    $ex->getFile(),
                    $ex->getLine(),
                    $ex->getMessage(),
                ]);
            }
        }

        return response()->json([
            'errors' => (object) [
                'form'   => $standardError,
                'inputs' => $validator->getMessageBag()->getMessages(),
            ],

            'status' => $status,
        ]);
    }

    private function createInitialRolesAndPermissionsAndUser(array $data): void
    {
        DB::transaction(function () use ($data) {
            /** @var Role */
            $adminRole = Role::create(['name' => 'administrator']);
            /** @var Role */
            $userRole = Role::create(['name' => 'user']);

            $siteAdminPermission  = Permission::create(['name' => 'site admin']);
            $superAdminPermission = Permission::create(['name' => 'super admin']);

            $adminRole->givePermissionTo($siteAdminPermission);

            $assignUpTokenPermission = Permission::create(['name' => 'assign token']);
            $editAccountsPermission  = Permission::create(['name' => 'edit accounts']);
            $seeAccountsPermission   = Permission::create(['name' => 'see accounts']);

            $userRole->givePermissionTo([
                $assignUpTokenPermission,
                $editAccountsPermission,
                $seeAccountsPermission,
            ]);

            $data['email_verified_at'] = Date::now();
            $data['created_at']        = Date::now();
            $data['updated_at']        = Date::now();

            /** @var User */
            $user = User::create($data);

            $user->assignRole($adminRole, $userRole);
            $user->givePermissionTo($superAdminPermission);
        });
    }
}
