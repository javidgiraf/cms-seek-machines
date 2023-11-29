<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Quoterequest;
use Image;
use Illuminate\Support\Facades\File;

class QuoteRequestService
{

    public function getQuoteRequests(): Object
    {
        return Quoterequest::all();
    }


    public function createQuoteRequest(array $userData): Quoterequest
    {

        $insert =  [
            'user_id'    => $userData['user_id'],
            'sell_machine_id'    => $userData['sell_machine_id'],
            'company'    => $userData['company'],
            'contact_name'    => $userData['contact_name'],
            'message'    => $userData['message'],
            'email'    => $userData['email'],
            'phone'    => $userData['phone'],
            'location'    => $userData['location'],


        ];

        if (!empty($userData['status'])) {
            $insert['status'] = $userData['status'];
        }
        return Quoterequest::create($insert);
    }
    public function getQuoteRequest($id): Object
    {
        return Quoterequest::find($id);
    }


    public function updateQuoteRequest(Quoterequest $quoteRequest, array $userData): void
    {
        $update = [
            'sell_machine_id'    => $userData['sell_machine_id'],
            'company'    => $userData['company'],
            'contact_name'    => $userData['contact_name'],
            'email'    => $userData['email'],
            'message'    => $userData['message'],
            'phone'    => $userData['phone'],
            'location'    => $userData['location'],
            'status'    => $userData['status'],
        ];


        $quoteRequest->update($update);

    }

    public function deleteQuoteRequest(Quoterequest $quoteRequest): void
    {
        // delete user
        Quoterequest::find($quoteRequest->id)->delete();

    }
}

