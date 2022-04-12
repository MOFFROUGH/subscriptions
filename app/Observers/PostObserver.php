<?php

namespace App\Observers;

use App\Jobs\EmailJob;
use App\Models\Post;
use App\Models\PostSent;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function created(Post $post)
    {
        // notify all users of new post via email
        foreach ($post->subscriptions as $subscription) {
            // use email jobs here....
            // check if this post has been sent..
            $isPostSent = PostSent::where('user_id', $subscription->user->id)->where('post_id', $post->id)->first();
            if (!$isPostSent) {
                dispatch(new EmailJob($subscription->user->email, $post));
                $postSent = PostSent::create([
                    'user_id' => $subscription->user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param \App\Models\Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
