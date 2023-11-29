<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BlogService;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogService $blogService)
    {
        //
        $blogs = $blogService->getBlogs();
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo Storage::disk('outside');
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BlogService $blogService)
    {
        //
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:blogs,slug',
            'default_image'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $input = $request->all();
        $image_upload = $blogService->uploadImage($request);
        $description_image_upload = $blogService->uploadDescriptionImage($request);
        $blogService->createBlogs($input, $image_upload, $description_image_upload);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully');
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
    public function edit($id, BlogService $blogService)
    {
        //
        $id = decrypt($id);
        $blog = $blogService->getBlog($id);
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, BlogService $blogService)
    {
        //
        $id = decrypt($id);
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $id,
            'default_image'      => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $input = $request->all();
        $blog = $blogService->getBlog($id);
        $image_upload = null;
        if (!empty($request->file('default_image'))) {
            ($blog->default_image) ? $blogService->deleteImage($blog->default_image) : '';
            $image_upload = $blogService->uploadImage($request);
        }

        $description_image_upload = $blogService->uploadDescriptionImage($request);
        $blogService->updateBlogs($blog, $input, $image_upload, $description_image_upload);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BlogService $blogService)
    {
        $blog = $blogService->getBlog($id);

        $blogService->deleteImage($blog->default_image);

        $blogService->deleteBlog($blog);

        return redirect()->back()
            ->with('success', 'Blog deleted successfully');
    }
}
