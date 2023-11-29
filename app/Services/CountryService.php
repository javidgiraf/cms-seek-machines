<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Country;

use Image;
use Illuminate\Support\Facades\File;

class CountryService
{

    public function getCountries(): Object
    {
        return Country::all();
    }


    public function createCountry(array $userData): Country
    {
        return Country::create([
            'name'    => $userData['name'],

        ]);
    }
    public function getCountry($id): Object
    {
        return Country::find($id);
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

    public function updateCountry(Country $country, array $userData): void
    {
        $update = [
            'name'    => $userData['name'],


        ];


        $country->update($update);

    }

    public function deleteCountry(Country $country): void
    {
        // delete user
        Country::find($country->id)->delete();

    }
}
