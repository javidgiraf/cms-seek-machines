<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Customer;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUsers(string $type): Object
    {
        if ($type == 'admin') {
            return User::where('is_admin', '1')->paginate(25);
        }
        if ($type == 'customer') {

            return User::where('is_admin', '0')->paginate(25);
        }
    }
    public function getCustomers(): Object
    {
        return User::where('is_admin', '0')->orderBy('name', 'asc')->get();
    }

    // public function uploadImage(Request $request): ?string
    // {
    //     $imageUrl = "";
    //     if ($request->hasfile('image_url')) {

    //         $file = $request->file('image_url');
    //         $assetName = $request->input('title') . time();
    //         // generate a new filename. getClientOriginalExtension() for the file extension
    //         $filename =  $assetName . '.' . $file->getClientOriginalExtension();
    //         $imageUrl = 'customers/' . $filename;

    //         // save to storage/app/public/brands as the new $filename
    //         $image = Image::make($file);
    //         $image->save(storage_path('app/public/' . $imageUrl));
    //     }
    //     return $imageUrl;
    // }

    public function createUser(array $userData): User
    {
        $insert = [
            'name'      => $userData['name'],
            'email'     => $userData['email'],
            'is_admin'  => $userData['is_admin'],

        ];
        if (!empty($userData['password'])) {
            $insert['password'] = Hash::make($userData['password']);
        }
        $user = User::create($insert);
        return $user;
    }
    public function assignUserRoles($userData, User $user): void
    {

        $roles = $userData['roles'];

        $user->assignRole($roles);
    }
    public function createCustomer(string $id, array $userData2): Customer
    {
        $insert2 = [
            'user_id'       => $id,
            'company'       => $userData2['company'],
            'phone'         => $userData2['phone'],
            'country_id'    => $userData2['country'],
        ];
        if (!empty($userData2['image_url'])) {
            $insert2['image_url'] = $userData2['image_url'];
        }
        if (!empty($userData2['status'])) {
            $insert2['status'] = $userData2['status'];
        }


        return Customer::create($insert2);
    }

    public function getUser($id): Object
    {
        return User::find($id);
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

    public function updateUser(User $user, array $userData): void
    {
        $update = [
            'name'    => $userData['name'],
            'email'    => $userData['email'],

        ];
        if (!empty($userData['password'])) {
            $update['password'] = Hash::make($userData['password']);
        }
        $user->update($update);

        if ($user->isadmin == 1) { // only for admin users
            $user->syncRoles($userData['roles']);
        }
    }

    public function updateCustomer(string $id, array $userData2): void
    {

        $customer = Customer::where('user_id', $id)->first();
        $update2 = [
            'company'       => $userData2['company'],
            'phone'         => $userData2['phone'],
            'country_id'    => $userData2['country'],
            'status'        => $userData2['status'],
        ];
        if (!empty($userData2['image_url'])) {
            $update2['image_url'] = $userData2['image_url'];
        }

        $customer->update($update2);
    }

    public function deleteUser(User $user): void
    {
        // delete user
        User::find($user->id)->delete();
    }

    public function updateStatus(array $userData): void
    {
        $customer = Customer::find($userData['itemid']);

        $customer->update(['status' => $userData['status']]);
    }
}
