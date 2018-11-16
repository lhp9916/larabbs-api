<?php

namespace App\Handlers;

use Image;
use Storage;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'jpeg'];

    /**
     * 上传文件到七牛云
     * @param $file
     * @param $folder
     * @param $file_prefix
     * @param bool $max_width
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        $folder_name = "images/$folder/" . date('Ym', time()) . '/' . date("d", time());

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($file->getRealPath(), $max_width);
        }
        if (env('UPLOAD_DISK', '') == 'qiniu') {
            //将图片上传刀七牛云
            $disk = Storage::disk('qiniu');
            $disk->write("$folder_name/$filename", file_get_contents($file->getRealPath()));

            return [
                'path' => 'http://' . env('QINIU_DOMAIN') . "/$folder_name/$filename",
            ];
        } else {
            $upload_path = public_path() . '/upload/' . $folder_name;
            //将图片移动到制定的目录中
            $file->move($upload_path, $filename);
            return [
                'path' => config('app.url') . "/upload/$folder_name/$filename",
            ];
        }
    }

    /**
     * 裁剪图片
     * @param $file_path
     * @param $max_width
     */
    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);
        $image->resize($max_width, null, function ($constraint) {
            //设定宽度是$max_width，高度等比例缩放
            $constraint->aspectRatio();
            //防止裁剪时图片尺寸变大
            $constraint->upsize();
        });
        $image->save();
    }
}