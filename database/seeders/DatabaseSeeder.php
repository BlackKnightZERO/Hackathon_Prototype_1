<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;

use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;
use App\Enums\ModuleEnum;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Ministry;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Module;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        foreach(RoleEnum::cases() as $data) {
            Role::create([
                'title'    => $data->value,
                'slug'     => SlugService::createSlug(Role::class, 'slug', $data->value, ['unique' => true]),
            ]);
        }

        foreach(ModuleEnum::cases() as $data) {
            $module = Module::create([
                'title'    => $data->value,
                'slug'     => SlugService::createSlug(Module::class, 'slug', $data->value, ['unique' => true]),
            ]);

            foreach(PermissionEnum::cases() as $data2) {
                Permission::create([
                    'title'    => $data2->value,
                    'module_id'=> $module->id,
                    'slug'     => SlugService::createSlug(Permission::class, 'slug', $data2->value, ['unique' => true]),
                ]);
            }
        }

        $adminPermissions = Permission::all();
        $adminRole = Role::find(1);
        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        $userRole = Role::find(2);
        $userRole->permissions()->sync([1, 6, 7, 9]);

        User::create([
            'first_name'    => 'Iam',
            'last_name'     => 'Admin',
            'email'         => 'admin@gmail.com',
            'username'      => 'admin-01',
            'password'      => Hash::make('123123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin'      => 1,
            'slug'          => SlugService::createSlug(User::class, 'slug', 'Admin', ['unique' => true]),
            'created_at'    => now(),
            'role_id'       => 1,
        ]);

        UserDetail::create([
            'user_id'       => 1,
            'institution'   => 'admin',
            'program'       => 'admin',
            'created_at'    => now(),
        ]);

        User::create([
            'first_name'    => 'Iam',
            'last_name'     => 'User',
            'email'         => 'user@gmail.com',
            'username'      => 'user-01',
            'password'      => Hash::make('123123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_admin'      => 0,
            'slug'          => SlugService::createSlug(User::class, 'slug', 'User', ['unique' => true]),
            'created_at'    => now(),
            'role_id'       => 2,
        ]);

        UserDetail::create([
            'user_id'           => 2,
            'academic_email'    => 'user@testcollege.com',
            'personal_email'    => 'user@yahoo.com',
            'institution'       => 'Test College',
            'program'           => 'CSE',
            'program_start'     => '2020-01-01',
            'program_end'       => '2023-01-01',
            'phone_1'           => '6136130000',
            'phone_2'           => '6136131111',
            'image_path'        => '',
            'resume_path'       => '',
            'created_at'        => now(),
        ]);

        Ministry::factory(29)->create();
        
    }
}
