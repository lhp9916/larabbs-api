<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        //创建权限
        Permission::create(['name' => 'manage_contents']);//管理内容
        Permission::create(['name' => 'manage_users']);//管理用户
        Permission::create(['name' => 'edit_setting']);//站点设置权限

        //创建站长角色，并赋予权限
        $founder = Role::create(['name' => 'Founder']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_setting');

        //创建管理员角色,并赋予权限
        $maintainer = Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清除缓存
        app()['cache']->forget('spatie.permission.cache');

        $tables = config('permission.table_names');
        Model::unguard();
        //  清空所有的数据
        DB::table($tables['role_has_permissions'])->delete();
        DB::table($tables['model_has_roles'])->delete();
        DB::table($tables['model_has_permissions'])->delete();
        DB::table($tables['roles'])->delete();
        DB::table($tables['permissions'])->delete();
        Model::reguard();
    }
}
