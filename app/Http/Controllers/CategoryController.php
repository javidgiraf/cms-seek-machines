<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CategoryService $categoryService)
    {
        //
        $input = $request->all();
        $categories = $categoryService->getAllCategory($input);

        $parents = $categoryService->categoryArray();

        return view('categories.index', compact('categories', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryService $categoryService)
    {
        //
        $parents = $categoryService->categoryArray();
        return view('categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CategoryService $categoryService)
    {
        //

        $request->validate([
            'name' => 'required',
            'short_code' => 'required|unique:categories,short_code',
            'icon_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();

        $image_upload = $categoryService->uploadImage($request);
        $categoryService->createCategory($input,$image_upload);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, CategoryService $categoryService)
    {
        //
        $id=decrypt($id);
        $parents = $categoryService->categoryArray();

        $category = $categoryService->getCategory($id);
        return view('categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,CategoryService $categoryService)
    {
        //
        $id=decrypt($id);
        $request->validate([
            'name' => 'required',
            'short_code' => 'required|unique:categories,short_code,' . $id,
            'icon_url'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();
        $category = $categoryService->getCategory($id);
        $image_upload = null;
        if (!empty($request->file('icon_url'))) {
            ($category->icon_url) ? $categoryService->deleteImage($category->icon_url) : '';
            $image_upload = $categoryService->uploadImage($request);
        }


        $categoryService->updateCatgeory($category, $input,$image_upload);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoryService $categoryService)
    {
        $category = $categoryService->getCategory($id);

        $categoryService->deleteImage($category->icon_url);

        $categoryService->deleteCategory($category);

        return redirect()->back()
            ->with('success', 'Category deleted successfully');
    }
}
