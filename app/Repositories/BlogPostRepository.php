<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BlogPostRepository
 *
 * @package App\Repositories
 */
class BlogPostRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get a list of articles to list
     * (Admin panel)
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
//            ->with(['category', 'user'])
            ->with([
                'category' => function ($query) {
                $query->select(['id', 'title']);
                },
                'user:id,name',
            ])
            ->paginate(25);

        return $result;
    }

    /**
     * Get the model for editing in the admin panel.
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return$this->startConditions()->find($id);
    }


}
