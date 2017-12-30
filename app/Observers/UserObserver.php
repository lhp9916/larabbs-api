<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function saving(User $user)
    {
        //指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = "https://avatars1.githubusercontent.com/u/10591282?s=460&v=4";
        }
    }

}