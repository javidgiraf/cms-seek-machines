<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\BuyerRequest;
use Image;
use Illuminate\Support\Facades\File;

class BuyerRequestService
{

    public function getBuyerRequests(): Object
    {
        return BuyerRequest::all();
    }


    public function createBuyerRequest(array $userData): BuyerRequest
    {

        $insert =  [
            'user_id'    => $userData['user_id'],
            'category_id'    => $userData['category_id'],
            'company'    => $userData['company'],
            'contact_name'    => $userData['contact_name'],
            'description'    => $userData['description'],
            'email'    => $userData['email'],
            'phone'    => $userData['phone'],
            'location'    => $userData['location'],
            'product'    => $userData['product'],

        ];

        if (!empty($userData['status'])) {
            $insert['status'] = $userData['status'];
        }
        return BuyerRequest::create($insert);
    }
    public function getBuyerRequest($id): Object
    {
        return BuyerRequest::find($id);
    }


    public function updateBuyerRequest(BuyerRequest $buyyerRequest, array $userData): void
    {
        $update = [
            'category_id'    => $userData['category_id'],
            'company'    => $userData['company'],
            'contact_name'    => $userData['contact_name'],
            'email'    => $userData['email'],
            'description'    => $userData['description'],
            'phone'    => $userData['phone'],
            'location'    => $userData['location'],
            'product'    => $userData['product'],
            'status'    => $userData['status'],
        ];


        $buyyerRequest->update($update);
    }

    public function deleteBuyerRequest(BuyerRequest $buyyerRequest): void
    {
        // delete user
        BuyerRequest::find($buyyerRequest->id)->delete();
    }
}
