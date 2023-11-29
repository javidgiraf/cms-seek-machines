<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Brand;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BrandService
{

    public function getBrands(): Object
    {
        return Brand::orderBy('id', 'asc')->get();
    }

    public function uploadImage(Request $request): ?string
    {
        $imageUrl = "";
        if ($request->hasfile('logo_url')) {

            $file = $request->file('logo_url');
            $assetName = $request->input('manufacturer') . time();
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename =  $assetName . '.' . $file->getClientOriginalExtension();
            $imageUrl = 'brands/' . $filename;

            // save to storage/app/public/brands as the new $filename
            $image = Image::make($file);

            //     Storage::disk('outside')->put($imageUrl, $imageUrl);


            // Storage::disk('public')->put('images/'.$img_name, file_get_contents($file));

            $image->save(storage_path('app/public/' . $imageUrl));
        }
        return $imageUrl;
    }
    public function createBrand(array $userData, string $imageUrl): Brand
    {
        $insert =
            [
                'manufacturer'    => $userData['manufacturer'],
                'short_code'    => $userData['short_code'],
                'logo_url'    => $imageUrl,
            ];

        if (!empty($userData['status'])) {
            $insert['status'] = $userData['status'];
        }
        return Brand::create($insert);
    }
    public function getBrand($id): Object
    {
        return Brand::find($id);
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

    public function updateBrand(Brand $brand, array $userData, string $imageUrl = null): void
    {
        $update = [
            'manufacturer'    => $userData['manufacturer'],
            'short_code'    => $userData['short_code'],
            'status'    => $userData['status'],

        ];
        if (!empty($imageUrl)) {
            $update['logo_url'] = $imageUrl;
        }

        $brand->update($update);
    }

    public function deleteBrand(Brand $brand): void
    {
        // delete user
        Brand::find($brand->id)->delete();
    }
}
