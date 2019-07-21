<?php

use App\Models\Admin;
use App\Models\RBAC\Role;
use App\Models\RBAC\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRBACTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'root',
            'email' => 'root@your.email',
            'password' => bcrypt('secret'),
        ]);
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@your.email',
            'password' => bcrypt('secret'),
        ]);
        Admin::create([
            'name' => 'visitor',
            'email' => 'visitor@your.email',
            'password' => bcrypt('secret'),
        ]);

        Role::create([
            'name' => 'root',
        ]);
        Role::create([
            'name' => 'administrator',
        ]);
        Role::create([
            'name' => 'editor',
        ]);

        Permission::create([
            'name' => '添加管理员权限',
            'action' => 'POST',
            'uri' => 'api/v0/admin/permissions',
        ]);
        Permission::create([
            'name' => '更新管理员权限',
            'action' => 'PUT',
            'uri' => 'api/v0/admin/permissions/{id}',
        ]);
        Permission::create([
            'name' => '删除管理员权限',
            'action' => 'DELETE',
            'uri' => 'api/v0/admin/permissions/{id}',
        ]);




        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 2],
            ['permission_id' => 3, 'role_id' => 2],
        ]);
    }
}
