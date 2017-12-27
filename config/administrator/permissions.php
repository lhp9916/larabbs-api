<?php

use Spatie\Permission\Models\Permission;

return [
    'title' => '权限',
    'single' => '权限',
    'model' => Permission::class,

    'permission' => function () {
        return Auth::user()->can('manage_users');
    },

    'action_permissions' => [
        //控制 新建按钮的显示
        'create' => function ($model) {
            return true;
        },
        //允许更新
        'update' => function ($model) {
            return true;
        },
        //不允许删除
        'delete' => function ($model) {
            return false;
        },
        //允许查看
        'view' => function ($model) {
            return true;
        },
    ],

    'columns' => [
        'id' => ['title' => 'ID'],

        'name' => ['title' => '标识'],

        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ]
    ],

    'edit_fields' => [
        'name' => [
            'title' => '标识（请谨慎修改）',
            'hint' => '修改权限标志会影响代码的调用，请不要轻易修改'
        ],
        'roles' => [
            'type' => 'relationship',
            'title' => '角色',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'name' => ['title' => '标示',],
    ],
];