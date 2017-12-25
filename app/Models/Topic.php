<?php

namespace App\Models;


class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    /**
     * 模型关联
     * $topic->category()获取分类
     * $topic->user()获取用户
     */


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        //不同的排序，使用不同数据读取逻辑
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }
        //预加载，防止n+1的问题
        return $query->with('user', 'category');
    }

    public function scopeRecent($query)
    {
        //按照时间顺序排序
        return $query->orderBy('created_at', 'desc');
    }

    //最新回复
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

}
