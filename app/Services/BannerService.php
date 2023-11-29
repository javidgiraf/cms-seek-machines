<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Banner;
use Image;
use Illuminate\Support\Facades\File;

class BannerService
{

    public function getBanners(): Object
    {
        return Banner::all();
    }

    public function uploadImage(Request $request): ?string
    {
        $imageUrl = "";
        if ($request->hasfile('image_url')) {

            $file = $request->file('image_url');
            $assetName = $request->input('title') . time();
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename =  $assetName . '.' . $file->getClientOriginalExtension();
            $imageUrl = 'banners/' . $filename;

            // save to storage/app/public/brands as the new $filename
            $image = Image::make($file);
            $image->save(storage_path('app/public/' . $imageUrl));
        }
        return $imageUrl;
    }
    public function createBanner(array $userData, string $imageUrl): Banner
    {
        return Banner::create([
            'title'    => $userData['title'],
            'description'    => $userData['description'],
            'label'    => $userData['label'],
            'image_url'    => $imageUrl,
            //'image_alt'    => $userData['image_alt'],
            'link_to'    => $userData['link_to'],
        ]);
    }
    public function getBanner($id): Object
    {
        return Banner::find($id);
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

    public function updateBanner(Banner $banner, array $userData, string $imageUrl = null): void
    {
        $update = [
            'title'    => $userData['title'],
            'description'    => $userData['description'],
            'label'    => $userData['label'],
            //  'image_alt'    => $userData['image_alt'],
            'link_to'    => $userData['link_to'],
        ];
        if (!empty($imageUrl)) {
            $update['image_url'] = $imageUrl;
        }

        $banner->update($update);
    }

    public function deleteBanner(Banner $banner): void
    {
        // delete user
        Banner::find($banner->id)->delete();
    }
}
