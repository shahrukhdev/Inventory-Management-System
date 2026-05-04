<?php

namespace App\Console\Commands;

use App\Models\Module;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = array(

            16 =>
                array(
                    'name' => 'users.view',
                    'module_name' => 'Users',
                ),
            17 =>
                array(
                    'name' => 'users.add',
                    'module_name' => 'Users',
                ),
            18 =>
                array(
                    'name' => 'users.edit',
                    'module_name' => 'Users',
                ),
            19 =>
                array(
                    'name' => 'users.delete',
                    'module_name' => 'Users',
                ),
            20 =>
                array(
                    'name' => 'permissions.view',
                    'module_name' => 'Permission',
                ),
            21 =>
                array(
                    'name' => 'permissions.add',
                    'module_name' => 'Permission',
                ),
            22 =>
                array(
                    'name' => 'permissions.delete',
                    'module_name' => 'Permission',
                ),
            23 =>
                array(
                    'name' => 'permissions.edit',
                    'module_name' => 'Permission',
                ),
            24 =>
                array(
                    'name' => 'roles.view',
                    'module_name' => 'Roles',
                ),
            25 =>
                array(
                    'name' => 'roles.add',
                    'module_name' => 'Roles',
                ),
            26 =>
                array(
                    'name' => 'roles.edit',
                    'module_name' => 'Roles',
                ),
            27 =>
                array(
                    'name' => 'roles.delete',
                    'module_name' => 'Roles',
                ),
            28 =>
                array(
                    'name' => 'department.view',
                    'module_name' => 'Department',
                ),
            29 =>
                array(
                    'name' => 'department.add',
                    'module_name' => 'Department',
                ),
            30 =>
                array(
                    'name' => 'department.edit',
                    'module_name' => 'Department',
                ),
            31 =>
                array(
                    'name' => 'department.delete',
                    'module_name' => 'Department',
                ),
            32 =>
                array(
                    'name' => 'brand.view',
                    'module_name' => 'Brand',
                ),
            33 =>
                array(
                    'name' => 'brand.add',
                    'module_name' => 'Brand',
                ),
            34 =>
                array(
                    'name' => 'brand.edit',
                    'module_name' => 'Brand',
                ),
            35 =>
                array(
                    'name' => 'brand.delete',
                    'module_name' => 'Brand',
                ),
            36 =>
                array(
                    'name' => 'product.view',
                    'module_name' => 'Product',
                ),
            37 =>
                array(
                    'name' => 'product.add',
                    'module_name' => 'Product',
                ),
            38 =>
                array(
                    'name' => 'product.edit',
                    'module_name' => 'Product',
                ),
            39 =>
                array(
                    'name' => 'product.delete',
                    'module_name' => 'Product',
                ),
            40 =>
                array(
                    'name' => 'vendor.view',
                    'module_name' => 'Vendors',
                ),
            41 =>
                array(
                    'name' => 'vendor.add',
                    'module_name' => 'Vendors',
                ),
            42 =>
                array(
                    'name' => 'vendor.edit',
                    'module_name' => 'Vendors',
                ),
            43 =>
                array(
                    'name' => 'vendor.delete',
                    'module_name' => 'Vendors',
                ),
            44 =>
                array(
                    'name' => 'invoice.view',
                    'module_name' => 'Invoice',
                ),
            45 =>
                array(
                    'name' => 'invoice.add',
                    'module_name' => 'Invoice',
                ),
            46 =>
                array(
                    'name' => 'invoice.edit',
                    'module_name' => 'Invoice',
                ),
            47 =>
                array(
                    'name' => 'invoice.delete',
                    'module_name' => 'Invoice',
                ),
            48 =>
                array(
                    'name' => 'product_item.view',
                    'module_name' => 'Product Item',
                ),
            49 =>
                array(
                    'name' => 'product_item.add',
                    'module_name' => 'Product Item',
                ),
            50 =>
                array(
                    'name' => 'product_item.edit',
                    'module_name' => 'Product Item',
                ),
            51 =>
                array(
                    'name' => 'product_item.delete',
                    'module_name' => 'Product Item',
                ),
            52 =>
                array(
                    'name' => 'assign_employee',
                    'module_name' => 'Product Item',
                ),
            53 =>
                array(
                    'name' => 'product_item_history.view',
                    'module_name' => 'Product Item',
                ),
            54 =>
                array(
                    'name' => 'product_item_history.add',
                    'module_name' => 'Product Item',
                ),
            55 =>
                array(
                    'name' => 'product_item_history.edit',
                    'module_name' => 'Product Item',
                ),
            56 =>
                array(
                    'name' => 'product_item_history.delete',
                    'module_name' => 'Product Item',
                ),
            57 =>
                array(
                    'name' => 'profile.view',
                    'module_name' => 'Profile',
                ),
            58 =>
                array(
                    'name' => 'profile.edit',
                    'module_name' => 'Profile',
                ),

        );


        foreach ($permissions as $permission) {

            $module = Module::firstOrCreate(['name' => $permission['module_name']]);
            $module->save();
            Permission::create(['name' => $permission['name'], 'module_id' => $module->id]);
        }


        $roles = array(
            0 =>
                array(
                    'name' => 'Super Admin',
                ),
        );


        $permissions = Permission::all()->pluck('name')->toArray();

        foreach ($roles as $role) {

            $r = Role::create(['name' => $role['name']]);

            if ($role['name'] == 'Super Admin') {
                $r->syncPermissions($permissions);
            }
        }


        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@projectcamp.app';
        $user->email_verified_at = now();
        $user->password = Hash::make('6xGJA7mqjcmIhOd'); // 6xGJA7mqjcmIhOd
        $user->remember_token = Str::random(10);
        $user->save();

        $user->assignRole('Super Admin');

        dump('Email: ' . $user->email);

        dump('Password: 6xGJA7mqjcmIhOd');


    }
}
