<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(15);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }


        // Creates object but doesn't add to DB
//        $item = new BlogCategory($data);
//        $item->save();

        // Creates object and adds to DB
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   int                     $id
     * @param   BlogCategoryRepository  $categoryRepository
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
//        $item = BlogCategory::findOrFail($id);
//        $categoryList = BlogCategory::all();

        $item = $categoryRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $categoryRepository->getForCombox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Record id=[{$id}] not found"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        $result = $item
            ->fill($data)
            ->save();

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()
                ->withErrors(['message' => 'Save error'])
                ->withInput();
        }
    }
}
