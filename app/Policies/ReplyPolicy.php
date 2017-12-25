<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function destroy(User $user, Reply $reply)
    {
        //回复的作者或话题的作者能删除
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
