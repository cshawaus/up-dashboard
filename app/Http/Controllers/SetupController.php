<?php

namespace App\Http\Controllers;

use App\Models\User;

use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Setup/Index', ['action' => route('setup.index')]);
    }

    public function finish(Request $request)
    {
        $status = false;

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users',
            'name'     => 'required|string|min:1',
            'password' => 'required|password|confirmed',
        ]);

        if (!$validator->fails()) {
            $this->createInitialRolesAndPermissionsAndUser($validator->validated());
        }

        // ->withErrors()
        // ->withInput($request->except(['password', 'password_confirmation']))
        // ->withFormStatus($status);
        return response()->json([
            'errors' => $validator->getMessageBag()->getMessages(),
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
            $user = User::create();

            $user->assignRole($adminRole, $userRole);
            $user->givePermissionTo($superAdminPermission);
        });
    }
}
