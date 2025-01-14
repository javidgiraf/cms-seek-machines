<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Banner;
use App\Models\BoostAd;
use App\Models\Sellmachine;
use App\Models\TransactionAd;
use Image;
use Illuminate\Support\Facades\File;
use App\Mail\BoostedAdMail;
use Mail;
use Config;

class BannerService
{

    public function getBanners(): Object
    {
        return Banner::select('banners.*')->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')->get();
    }


    public function getActiveBanners(): Object
    {
        //return Banner::where('status', '1')->get();
        return Banner::select('banners.*')
            ->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')
            ->where('boost_ads.status', '1')
            ->get();
    }


    public function getTransactionBoostAd(): Object
    {
        return TransactionAd::all();
        //return Banner::where('status', '1')->get();
        // return Banner::select('banners.*')->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')->where('boost_ads.status', '1')->get();
    }
    public function getInActiveBanners(): Object
    {
        return Banner::select('banners.*')->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')->where('boost_ads.status', '0')->get();
    }
    public function getOnReviewBanners(): Object
    {
        return Banner::select('banners.*')->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')->where('boost_ads.status', '2')->get();
    }

    // public function uploadImage(Request $request): ?string
    // {
    //     $imageUrl = "";
    //     if ($request->hasfile('image_url')) {

    //         $file = $request->file('image_url');
    //         $assetName = $request->input('title') . time();
    //         // generate a new filename. getClientOriginalExtension() for the file extension
    //         $filename =  $assetName . '.' . $file->getClientOriginalExtension();
    //         $imageUrl = 'banners/' . $filename;

    //         // save to storage/app/public/brands as the new $filename
    //         $image = Image::make($file);
    //         $image->save(storage_path('app/public/' . $imageUrl));
    //     }
    //     return $imageUrl;
    // }
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

    public function getBoosterAd($id): Object
    {
        $banner = Banner::find($id);
        return BoostAd::where('id', $banner->boost_ad_id)->first();
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

    public function updateBanner(Banner $banner, array $userData): void
    {
        $update = [
            'title'             => $userData['title'],
            'description'       => $userData['description'],
            'label'             => $userData['label'],
            'link_to'           => $userData['link_to'],
            'image_url'         => $userData['image_url'],
        ];

        $banner->update($update);

        // Boosted Ad Update Settings
        $boostAd = BoostAd::find($banner->boost_ad_id);
        $boostAd->days = $userData['no_of_days'];
        $boostAd->total_amount = $userData['total_amount'];
        $boostAd->start_date = $userData['start_date'];
        $boostAd->end_date = $userData['end_date'];
        $boostAd->save();
    }

    public function updateBannerStatus(BoostAd $boostadd, array $userData): void
    {
        $update = [
            'status'    => $userData['status'],
            // 'start_date'    => $userData['start_date'],
            // 'end_date'    => $userData['end_date'],
        ];
        $boostadd->update($update);
        
        $sellmachine = SellMachine::find($boostadd->sell_machine_id);
        $user = $sellmachine->user;
        $boostad_details = $boostadd;
        switch ($userData['status']) {
          case "1":
            $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Boostad submission has been Activated by the Admin. Details are following', 
        //    'image'=>$input,
            'user'=>$user, 
            'sellmachine'=>$sellmachine,
            'boostad'=>$boostad_details,
            'status' => "Active", 
            'regards' => 'Seeko'
            
        ];
            break;
          case "0":
             $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Boostad submission has been deactivated by the Admin. Details are following', 
           // 'image'=>$input,
            'user'=>$user, 
            'sellmachine'=>$sellmachine,
            'boostad'=>$boostad_details,
            'status' => "In Active", 
            'regards' => 'Seeko'
            
        ];
            break;
        
          default:
             $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Boostad submission has been put under review. Details are following', 
          //  'image'=>$input,
            'user'=>$user, 
            'sellmachine'=>$sellmachine,
            'boostad'=>$boostad_details,
            'status' => "On Review", 
            'regards' => 'Seeko'
            
        ];
        }
        
        Mail::to($user->email)->send(new BoostedAdMail($customer_data)); 
        $banner = Banner::where("boost_ad_id", $boostadd->id)->first();
        $banner->status = $userData['status'];
        $banner->save();
    }

    public function deleteBanner(Banner $banner): void
    {
        // delete user
        BoostAd::find($banner->boost_ad_id)->delete();


        Banner::find($banner->id)->delete();
    }
}
