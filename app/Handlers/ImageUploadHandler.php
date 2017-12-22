<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'jpeg'];

    /**
     * 上传文件到public/upload/images目录下
     * @param $file
     * @param $folder
     * @param $file_prefix
     * @param bool $max_width
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        $folder_name = "upload/images/$folder/" . date('Ym', time()) . '/' . date("d", time());

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        //将图片移动到制定的目录中
        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename",
        ];
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