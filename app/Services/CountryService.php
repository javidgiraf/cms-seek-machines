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
        return Country::paginate(25);
    }
    public function getAllCountries(): Object
    {
        return Country::orderBy('name', 'asc')->get();
    }

    public function signupCountries(): Object
    {
        return Country::where('allow_signup', 1)->orderBy('name', 'asc')->get();
    }



    public function createCountry(array $userData): Country
    {

        return Country::create([
            'name'    => $userData['name'],
            'allow_signup'    => (isset($userData['allow_signup']) && $userData['allow_signup']) ? 1 : 0,
           'flag'          => isset($userData['image_url']) ? $userData['image_url'] : ''
        ]);

    }
    public function getCountry($id): Object
    {
        return Country::find($id);
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

    public function updateCountry(Country $country, array $userData): void
    {

        $update = [
            'name'    => $userData['name'],
            'allow_signup'    => (isset($userData['allow_signup']) && $userData['allow_signup']) ? 1 : 0,
           'flag'          => isset($userData['image_url']) ? $userData['image_url'] : ''
        ];


        $country->update($update);
    }

    public function deleteCountry(Country $country): void
    {
        // delete user
        Country::find($country->id)->delete();
    }
}
