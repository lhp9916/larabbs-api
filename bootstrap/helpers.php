<?php
//自定义辅助函数

//将当前请求的路由名称转换为 CSS 类名称
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    $model_name = model_plural_name($model);

    $prefix = $prefix ? "/$prefix/" : '/';

    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    $class_full_name = get_class($model);

    $class_name = class_basename($class_full_name);

    $snake_case_name = snake_case($class_name);

    return str_plural($snake_case_name);
}

