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
        // $query = DB::table('categories as child')
        //     ->leftJoin('categories as parent', 'child.parent_id', '=', 'parent.id')
        //     ->select('child.*', 'parent.name as parent');

        // $categories = $query->orderBy('child.name', 'DESC')->get();

        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

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

    public function uploadImage(Request $request): ?string
    {
        $imageUrl = "";
        if ($request->hasfile('icon_url')) {

            $file = $request->file('icon_url');
            $assetName = $request->input('name') . time();
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename =  $assetName . '.' . $file->getClientOriginalExtension();
            $imageUrl = 'categories/' . $filename;

            // save to storage/app/public/brands as the new $filename
            $image = Image::make($file);
            $image->save(storage_path('app/public/' . $imageUrl));
        }
        return $imageUrl;
    }
    public function createCategory(array $userData,string $imageUrl): Category
    {
        $insert=[
            'name'        => $userData['name'],
            'short_code' => $userData['short_code'],
            'icon_url'   => $imageUrl,
        ];
        if (isset($userData['parent_id']) && !empty($userData['parent_id'])) {
            $update['parent_id'] = $userData['parent_id'];
        }
        return Category::create($insert);
    }

    public function deleteImage(string $imageUrl): void
    {
        // delete image
        if ($imageUrl) {
            $image_path = storage_path('app/public/') . $imageUrl; // upload path
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    public function updateCatgeory(Category $category, array $userData, string $imageUrl = null): void
    {
        $update = [
            'name'        => $userData['name'],
            'short_code' => $userData['short_code'],

        ];
        if (isset($userData['parent_id']) && !empty($userData['parent_id'])) {
            $update['parent_id'] = $userData['parent_id'];
        }
        if (!empty($imageUrl)) {
            $update['icon_url'] = $imageUrl;
        }

        $category->update($update);

    }

    public function deleteCategory(Category $category): void
    {
        // delete user
        Category::find($category->id)->delete();

    }
}
