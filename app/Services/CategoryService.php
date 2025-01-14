<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Category;
use Image;
use Illuminate\Support\Facades\File;

class CategoryService
{

    public function getAllCategory($data = []): Object
    {

        $categories = Category::orderBy('id', 'ASC')->paginate(25);

        return $categories;
    }


    public function getCategory($id): Object
    {
        return Category::find($id);
    }

    public function categoryArray()
    {
        return Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    // public function uploadImage(Request $request): ?string
    // {
    //     $imageUrl = "";
    //     if ($request->hasfile('icon_url')) {

    //         $file = $request->file('icon_url');
    //         $assetName = $request->input('name') . time();
    //         // generate a new filename. getClientOriginalExtension() for the file extension
    //         $filename =  $assetName . '.' . $file->getClientOriginalExtension();
    //         $imageUrl = 'categories/' . $filename;

    //         // save to storage/app/public/brands as the new $filename
    //         $image = Image::make($file);
    //         $image->save(storage_path('app/public/' . $imageUrl));
    //     }
    //     return $imageUrl;
    // }
    public function createCategory(array $userData): Category
    {

        $insert = [
            'name'        => $userData['name'],
            'short_code' => $userData['short_code'],
            'icon_url'   => $userData['image_url'],
        ];
        if (isset($userData['parent_id']) && !empty($userData['parent_id'])) {
            $insert['parent_id'] = $userData['parent_id'];
        }
        if (isset($userData['meta_title']) && !empty($userData['meta_title'])) {
            $insert['meta_title'] = $userData['meta_title'];
        }
        if (isset($userData['keywords']) && !empty($userData['keywords'])) {
            $insert['keywords'] = $userData['keywords'];
        }
        if (isset($userData['meta_descriptions']) && !empty($userData['meta_descriptions'])) {
            $insert['meta_descriptions'] = $userData['meta_descriptions'];
        }
        return Category::create($insert);
    }

    // public function deleteImage(string $imageUrl): void
    // {
    //     // delete image
    //     if ($imageUrl) {
    //         $image_path = storage_path('app/public/') . $imageUrl; // upload path
    //         if (File::exists($image_path)) {
    //             File::delete($image_path);
    //         }
    //     }
    // }

    public function updateCatgeory(Category $category, array $userData): void
    {
        $update = [
            'name'       => $userData['name'],
            'short_code' => $userData['short_code'],
            'status'    => $userData['status']
        ];
        if (isset($userData['parent_id']) && !empty($userData['parent_id'])) {
            $update['parent_id'] = $userData['parent_id'];
        }
        if (isset($userData['meta_title']) && !empty($userData['meta_title'])) {
            $update['meta_title'] = $userData['meta_title'];
        }
        if (isset($userData['keywords']) && !empty($userData['keywords'])) {
            $update['keywords'] = $userData['keywords'];
        }
        if (isset($userData['meta_descriptions']) && !empty($userData['meta_descriptions'])) {
            $update['meta_descriptions'] = $userData['meta_descriptions'];
        }
        if (!empty($userData['image_url'])) {
            $update['icon_url']   = $userData['image_url'];
        }

        $category->update($update);
    }

    public function deleteCategory(Category $category): void
    {
        // delete user
        Category::find($category->id)->delete();
    }
}
