<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\MembershipPlan;

use Image;
use Illuminate\Support\Facades\File;

class MembershipPlanService
{

    public function getMemberships(): Object
    {
        return MembershipPlan::all();
    }
    public function createMembershipPlan(array $userData): MembershipPlan
    {
        return MembershipPlan::create([
            'title'         => $userData['title'],
            'description'   => $userData['description'],
            'pricing'       => $userData['pricing'],
            'no_of_month'   => $userData['no_of_month'],
            'discount'      => $userData['discount'],
            'view_limit'    => $userData['view_limit'],
            'is_premium'    => isset($userData['is_premium']) ? 1 : 0,
            'min_premium_amount'   => $userData['min_premium_amount'],
            'max_premium_amount'   => $userData['max_premium_amount']
        ]);
    }
    public function getMembershipPlan($id): Object
    {
        return MembershipPlan::find($id);
    }

    public function updateMembershipPlan(MembershipPlan $MembershipPlan, array $userData): void
    {

        $update = [
            'title'         => $userData['title'],
            'description'   => $userData['description'],
            'pricing'       => $userData['pricing'],
            'no_of_month'   => $userData['no_of_month'],
            'discount'      => $userData['discount'],
            'view_limit'    => $userData['view_limit'],
            'is_premium'    => isset($userData['is_premium']) ? 1 : 0,
            'min_premium_amount'   => $userData['min_premium_amount'],
            'max_premium_amount'   => $userData['max_premium_amount'],
            'status'               => $userData['status'],
        ];
        $MembershipPlan->update($update);
    }

    public function deleteMembershipPlan($id): void
    {
        // delete user
        MembershipPlan::find($id)->delete();
    }
}
