<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{

    /**
     * Processing before creating an article.
     *
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost)
    {
        //
    }

    /**
     * Processing before updating an article.
     *
     * @param BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

    }

    /**
     * If the publication date is not set and the flag is set to
     * Published, then set the publication date to the current
     *
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if (empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * If the slug field is empty, then fill
     * it with the header conversion.
     *
     * @param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = \Str::slug($blogPost->title);
        }
    }

    /**
     * Handle the blog post "created" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     *
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     *
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     *
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     *
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     *
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
