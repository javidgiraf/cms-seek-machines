<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Sellmachine;
use App\Models\Sellmachineimage;
use Image;
use Illuminate\Support\Facades\File;

class SellmachineService
{

    public function getSellMachines(): Object
    {
        return Sellmachine::all();
    }

    public function getActiveSellMachines(): Object
    {
        return Sellmachine::where('status', '1')->get();
    }
    public function getInActiveSellMachines(): Object
    {
        return Sellmachine::where('status', '0')->get();
    }
    public function getPendingSellMachines(): Object
    {
        return Sellmachine::where('status', '2')->get();
    }

    public function uploadImage(Request $request): ?string
    {
        $imageUrl = "";
        if ($request->hasfile('default_image')) {

            $file = $request->file('default_image');
            $assetName = $request->input('title') . time();
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename =  $assetName . '.' . $file->getClientOriginalExtension();
            $imageUrl = 'machines/' . $filename;

            // save to storage/app/public/brands as the new $filename
            $image = Image::make($file);
            $image->save(storage_path('app/public/' . $imageUrl));
        }
        return $imageUrl;
    }
    public function uploadDescriptionImage(Request $request): ?string
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);
        libxml_use_internal_errors(true);
        $detail = "";
        if (isset($request->description) && !empty($request->description)) {
            $detail =  $request->description;

            // $dom = new \domdocument();
            // $dom->loadHtml(
            //     mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'),
            //     LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            // );
            // $images = $dom->getelementsbytagname('img');

            // //loop over img elements, decode their base64 src and save them to public folder,
            // //and then replace base64 src with stored image URL.
            // foreach ($images as $k => $img) {
            //     $data = $img->getattribute('src');


            //     if (preg_match('/data:image/', $data)) {
            //         preg_match('/data:image\/(?<mime>.*?)\;/', $data, $groups);
            //         $mimeType = $groups['mime'];

            //         $image_name = "/uploads/machines/" . time() . $k . '.' . $mimeType;

            //         Image::make($data)
            //             ->resize(750, null, function ($constraint) {
            //                 $constraint->aspectRatio();
            //             })
            //             ->encode($mimeType, 80)
            //             ->save(public_path($image_name));

            //         $img->removeAttribute('src');
            //         $img->setAttribute('src', asset($image_name));
            //     }
            // }

            // $detail = $dom->savehtml();

        }
        return $detail;
    }
    public function createSellMachine(string $price_visible, array $userData, string $imageUrl, string $detail): Sellmachine
    {
        $userData['item_code'] = $this->getReferenceNumber();

        $insert =  [
            'title'    => $userData['name'],
            'description'    => $detail,
            'default_image'    => $imageUrl,
            //'slug'    => $userData['slug'],
            'item_code'    => $userData['item_code'],
            'user_id'    => $userData['user_id'],
            'category_id'    => $userData['category_id'],
            'brand_id'    => $userData['brand_id'],
            'country_id'    => $userData['country_id'],
            'yearof'    => $userData['yearof'],
            'modelno'    => $userData['modelno'],
            'usage'    => $userData['usage'],
            'location'    => $userData['location'],
        ];

        if (!empty($userData['status'])) {
            $insert['status'] = $userData['status'];
        }

        return Sellmachine::create($insert);
    }

    public function uploadCatalog($request, $id)
    {
        // Save technical catalog
        if (!empty($request->file('file_path'))) {
            $fileName = time() . '.' . $request->file('file_path')->extension();
            $request->file_path->storeAs('public/catalog/', $fileName);
            $doc_file = 'catalog/' . $fileName;

            DB::table('machine_catalogs')->insert([
                'sell_machine_id' => $id,
                'file_path'       => $doc_file,
                'file_type'       => 'technical'
            ]);
        }
    }

    public function addSpecifications($input, $id)
    {

        // save specifications
        $insertSpec = [];
        foreach ($input['spec_title'] as $i => $title) {

            if (isset($input['spec_value'][$i]) && !empty($input['spec_value'][$i])) {
                $insertSpec = [
                    'sell_machine_id' => $id,
                    'spec_title'    => $title,
                    'spec_value'    => $input['spec_value'][$i]
                ];
                DB::table('machine_specifications')->insert($insertSpec);
            }
        }
    }

    public function getReferenceNumber()
    {
        $StartNo = 1;
        $last = SellMachine::latest()->first();
        // $lastId = ($last) ? $last->id : $StartNo;

        $lastId = ($last) ? ($StartNo + $last->id) : $StartNo;

        $randStr =  "SM/AD/" . date('y') . '/' . $lastId;

        return $randStr;
    }

    public function getSellMachine($id): Object
    {
        return Sellmachine::find($id);
    }

    public function getSellMachineImages($id): Object
    {
        return Sellmachineimage::where('sell_machine_id', $id)->get();
    }
    public function getSellMachineImage($id): Object
    {
        return Sellmachineimage::where('id', $id)->first();
    }
    public function getSpecifications($id): Object
    {
        return DB::table('machine_specifications')->where('sell_machine_id', $id)->get();
    }
    public function getCatalogs($id): Object
    {

        $catalogue_null = [
            'id' => '0',
            'sell_machine_id' => $id,
            'file_path' => '',
        ];
        $catalogue_null = (object) $catalogue_null;

        $catelogue = DB::table('machine_catalogs')->where('sell_machine_id', $id)->first();
        return ($catelogue != "") ? $catelogue : $catalogue_null;
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
    public function deleteSpecification($id)
    {
        $sql = DB::table('machine_specifications')->where('id', $id);
        if ($sql->count() > 0) {
            $sql->delete();
            return true;
        }
        return false;
    }

    public function insertSellmachineimages(string $id, array $input, Request $request)
    {

        $sellingMachineImages = [];
        if (!empty($request->file('repeater-list'))) {

            foreach ($request->file('repeater-list') as $i => $ifile) {

                $imageUrl = '';

                if ($ifile['image_url']) {

                    $file = $ifile['image_url'];

                    $assetName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . time();

                    $assetName = preg_replace("/\s+/", "-", $assetName);

                    // generate a new filename. getClientOriginalExtension() for the file extension

                    $filename =  $assetName . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                    $imageUrl = 'machines/' . $filename;
                    // save to storage/app/public/teams as the new $filename

                    $image = Image::make($file);

                    $image->save(storage_path('app/public/' . $imageUrl));

                    $sellingMachineImages[$i] = $imageUrl;
                }
            }
        }



        // insert product models
        if (isset($input["repeater-list"]) && !empty($input["repeater-list"])) {

            foreach ($input["repeater-list"] as $j => $nimage) {

                // get product models image

                $imageUrl = (isset($sellingMachineImages[$j]) && $sellingMachineImages[$j]) ? $sellingMachineImages[$j] : '';

                Sellmachineimage::insert([
                    'sell_machine_id'  => $id,
                    'image_url'        => $imageUrl

                ]);
            }
        }
    }

    public function updateSellmachine(string $id, string $price_visible, Sellmachine $sellmachine, array $userData, string $imageUrl = null, string $detail = null): void
    {
        $update = [
            'title'    => $userData['name'],
            'description'    => $detail,
            //  'slug'    => $userData['slug'],
            'item_code'    => $userData['item_code'],
            'category_id '    => $userData['category_id'],
            'brand_id'    => $userData['brand_id'],
            'country_id'    => $userData['country_id'],
            'yearof'    => $userData['yearof'],
            'modelno'    => $userData['modelno'],
            'usage'    => $userData['usage'],
            'location'    => $userData['location'],
            'status'    => $userData['status'],
        ];
        if (!empty($imageUrl)) {
            $update['default_image'] = $imageUrl;
        }


        $sellmachine->update($update);
    }

    public function deleteSellMachine(Sellmachine $sellmachine): void
    {
        // delete user
        Sellmachine::find($sellmachine->id)->delete();
    }

    public function deleteSellMachineImage(Sellmachineimage $sellmachineimage): void
    {
        // delete user
        Sellmachineimage::find($sellmachineimage->id)->delete();
    }

    public function updateCatalog($request, $id)
    {

        // Save technical catalog
        if (!empty($request->file('file_path'))) {
            // remove existing file
            $oldSql = DB::table('machine_catalogs')->where('sell_machine_id', $id);
            $existing = $oldSql->count() || 0;
            if ($existing) {
                $oldpdf = $oldSql->first();
                $this->imageDelete($oldpdf->file_path);
                DB::table('machine_catalogs')->where('sell_machine_id', $id)->delete();
            }
            // new file upload and save
            $fileName = time() . '.' . $request->file('file_path')->extension();
            $request->file_path->storeAs('public/catalog/', $fileName);
            $doc_file = 'catalog/' . $fileName;

            DB::table('machine_catalogs')->insert([
                'sell_machine_id' => $id,
                'file_path'       => $doc_file,
                'file_type'       => 'technical'
            ]);
        }
    }

    //  image file deleted   
    private function imageDelete($imageurl)
    {
        if (!$imageurl) return false;

        $image_path = storage_path('app/public/') . $imageurl; // upload path  
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
