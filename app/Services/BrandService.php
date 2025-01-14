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
use Illuminate\Support\Facades\Config;

class BrandService
{

    public function getBrands(): Object
    {
        return Brand::orderBy('id', 'asc')->paginate(25);
    }
    public function getAllBrands(): Object
    {
        return Brand::orderBy('manufacturer', 'asc')->get();
    }

    // public function uploadImage(Request $request): ?string
    // {

    //     $imageUrl = "";

    //     if ($request->hasfile('single_image_url')) {

    //         $image_folder = $request->image_folder;

    //         // $file = $request->file('single_image_url');
    //         // $assetName = $request->input('manufacturer') . time();
    //         // $filename =  $assetName . '.' . $file->getClientOriginalExtension();
    //         // $imageUrl = $image_folder . '/' . $filename;

    //         $imgUrl = $request->file('single_image_url');
    //         $image = file_get_contents($imgUrl);

    //         $destinationPath = base_path() . '/seek';
    //         //base_path() . '/seekmachines/storage/app/public/' . $image_folder . '/';

    //         // file_put_contents($destinationPath, $image);
    //         if (move_uploaded_file(
    //             $_FILES["single_image_url"]["tmp_name"],
    //             $destinationPath
    //         )) {
    //             echo "The file " .  $_FILES["single_image_url"]["name"] .
    //                 " has been uploaded.";
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //         die();

    //         /////////////////////

    //     }

    //     return $imageUrl;
    // }


    public function createBrand(array $userData): Brand
    {
        $insert =
            [
                'manufacturer'  => $userData['manufacturer'],
                'short_code'    => $userData['short_code'],
                'logo_url'      => $userData['image_url'],
                'ispopular'     => (isset($userData['ispopular']) && $userData['ispopular']) ? 1 : 0
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
    // public function deleteImage(string $imageUrl): void
    // {
    //     // delete image
    //     $input['imageurl'] = $imageUrl;

    //     $url = Config::get('app.api_url') . "/deleteImage";

    //     $response = $this->postData($url, $input);
    // }

    // public function postData($url, $params)
    // {
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $response = curl_exec($ch);
    //     $err = curl_error($ch);  //if you need

    //     curl_close($ch);

    //     return $response;
    // }

    public function updateBrand(Brand $brand, array $userData): void
    {
        $update = [
            'manufacturer'  => $userData['manufacturer'],
            'short_code'    => $userData['short_code'],
            'ispopular'     => (isset($userData['ispopular']) && $userData['ispopular']) ? 1 : 0,
            'status'        => $userData['status'],

        ];
        if (!empty($userData['image_url'])) {
            $update['logo_url'] = $userData['image_url'];
        }

        $brand->update($update);
    }

    public function updateStatus(array $userData): void
    {
        $brand = Brand::find($userData['itemid']);

        $brand->update(['status' => $userData['status']]);
    }

    public function deleteBrand(Brand $brand): void
    {
        // delete user
        Brand::find($brand->id)->delete();
    }
}
