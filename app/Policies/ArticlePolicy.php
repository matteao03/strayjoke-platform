<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Article $article)
    {
        return $article->user_id == $user->id;
    }
    
    public function destroy(User $user,Article $article)
    {
        return $article->user_id == $user->id;
    }
}
