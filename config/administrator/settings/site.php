<?php
return [

    'title' => '站点设置',

    'permission' => function () {
        //只允许站长才能访问
        return Auth::user()->hasRole('Founder');
    },

    'edit_fields' => [
        'site_name' => [
            'title' => '站点名称',
            'type'  => 'text',
            //字数限制
            'limit' => '50',
        ],

        'contact_email' => [
            'title' => '联系人邮箱',
            'type'  => 'text',
            'limit' => 50,
        ],

        'seo_description' => [
            'title' => 'SEO - Description',
            'type'  => 'textarea',
            'limit' => 250,
        ],
        'seo_keyword'     => [
            'title' => 'SEO - Keyword',
            'type'  => 'textarea',
            'limit' => 250,
        ],
    ],

    'rules' => [
        'site_name'     => 'required|max:50',
        'contact_email' => 'email',
    ],

    'messages' => [
        'site.name.required'  => '请填写站点名称',
        'contact_email.email' => '请填写正确的联系人邮箱格式',
    ],

    'actions' => [
        'clear_cache' => [
            'title'    => '更新系统缓存',
            'messages' => [
                'active'  => '正在清除缓存',
                'success' => '缓存已清空',
                'error'   => '清除缓存出错',
            ],

            'action' => function (&$data) {
                \Artisan::call('cache:clear');
                return true;
            },
        ],
    ],
];