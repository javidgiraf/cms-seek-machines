<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Setting;
use Image;
use Illuminate\Support\Facades\File;

class SettingService
{

    public function getSettings(): Object
    {
        return Setting::orderBy('id', 'desc')->get();
    }

    public function createSetting(array $userData): Setting
    {
        return Setting::create([
            'title'    => $userData['title'],
            'def_value'    => $userData['def_value'],
            'status'    => $userData['status'],

        ]);
    }
    public function getSetting($id): Object
    {
        return Setting::find($id);
    }

    public function getSettingByTitle($title): Object
    {
        return Setting::where('title', $title)->first();
    }


    public function updateSetting(Setting $setting, array $userData): void
    {
        $update = [
            'title'    => $userData['title'],
            'def_value' => $userData['def_value'],
            'status'    => $userData['status'],
        ];

        $setting->update($update);
    }

    public function deleteSetting(Setting $setting): void
    {
        // delete user
        Setting::find($setting->id)->delete();
    }
}
