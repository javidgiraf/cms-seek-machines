<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Blog;
use Image;
use Illuminate\Support\Facades\File;

class BlogService
{

    public function getBlogs(): Object
    {
        return Blog::all();
    }

    public function uploadImage(Request $request): ?string
    {
        $imageUrl = "";
        if ($request->hasfile('default_image')) {

            $file = $request->file('default_image');
            $assetName = $request->input('title') . time();
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename =  $assetName . '.' . $file->getClientOriginalExtension();
            $imageUrl = 'blogs/' . $filename;

            // save to storage/app/public/brands as the new $filename
            $image = Image::make($file);
            $image->save(storage_path('app/public/' . $imageUrl));
        }
        return $imageUrl;
    }
    public function uploadDescriptionImage(Request $request): ?string
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
        libxml_use_internal_errors(true);
        $detail = "";
        if (isset($request->description) && !empty($request->description)) {
            $detail =  $request->description;

            $dom = new \domdocument();
            $dom->loadHtml(
                mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );
            $images = $dom->getelementsbytagname('img');

            //loop over img elements, decode their base64 src and save them to public folder,
            //and then replace base64 src with stored image URL.
            foreach ($images as $k => $img) {
                $data = $img->getattribute('src');


                if (preg_match('/data:image/', $data)) {
                    preg_match('/data:image\/(?<mime>.*?)\;/', $data, $groups);
                    $mimeType = $groups['mime'];

                    $image_name = "/uploads/blogs/" . time() . $k . '.' . $mimeType;

                    Image::make($data)
                        ->resize(750, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->encode($mimeType, 80)
                        ->save(public_path($image_name));

                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($image_name));
                }
            }

            $detail = $dom->savehtml();
        }
        return $detail;
    }

    public function createBlogs(array $userData, string $imageUrl, string $detail): Blog
    {
        return Blog::create([
            'title'    => $userData['title'],
            'slug'    => $userData['slug'],
            'description'    => $detail,
            'default_image'    => $imageUrl,
            'meta_title'    => $userData['meta_title'],
            'meta_description'    => $userData['meta_description'],
        ]);
    }
    public function getBlog($id): Object
    {
        return Blog::find($id);
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

    public function updateBlogs(Blog $blog, array $userData, string $imageUrl = null, string $detail = null): void
    {
        $update = [
            'title'    => $userData['title'],
            'slug'    => $userData['slug'],
            'description'    => $detail,
            'meta_title'    => $userData['meta_title'],
            'meta_description'    => $userData['meta_description'],

        ];
        if (!empty($imageUrl)) {
            $update['default_image'] = $imageUrl;
        }

        $blog->update($update);
    }

    public function deleteBlog(Blog $blog): void
    {
        // delete user
        Blog::find($blog->id)->delete();
    }
}
