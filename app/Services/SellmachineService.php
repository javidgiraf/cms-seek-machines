<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Arr;
use App\Models\Sellmachine;
use App\Models\VerificationReason;
use App\Models\Sellmachineimage;
use App\Models\MachineCatalog;
use App\Models\TransactionVerifyAd;
use App\Models\SellMachineAgent;
use Image;
use Illuminate\Support\Facades\File;


class SellmachineService
{

  public function getSellMachines(): Object
  {
    return Sellmachine::get();
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

  public function getAdVerifySuccessSellMachines(): Object
  {
    return Sellmachine::where('isverified', '1')->get();
  }
  public function getAdVerifyFailedSellMachines(): Object
  {
    return Sellmachine::where('isverified', '0')->get();
  }
  public function getAdVerifyPendingSellMachines(): Object
  {
    return Sellmachine::where('isverified', '2')->get();
  }

  public function getReport($id): Object
  {

    return VerificationReason::where('sell_machine_id', $id)->get();
  }


  public function getAllTransactionReport(): Object
  {

    return TransactionVerifyAd::all();
  }

  public function insertReport(array $userData, Sellmachine $sellmachine): void
  {
    $report =  VerificationReason::where('sell_machine_id', $sellmachine->id)->first();

    if ($report) {
      // if report already exists
      $update = [
        'description' => $userData['description'],
        'inspection_file' => $userData['inspection_file'],
        'verified_on' => $userData['verified_on'],
        'agent_id' => $userData['agent_id'],
      ];
      $report->update($update);
    } else {
      // if reports does not exists
      $insert = [
        'sell_machine_id' => $sellmachine->id,
        'description'     => $userData['description'],
        'inspection_file' => $userData['inspection_file'],
        'verified_on'     => $userData['verified_on'],
        'agent_id' => $userData['agent_id'],
      ];
      VerificationReason::create($insert);
    }

    $sellmachine->update([
      'isverified'      => $userData['isverified'],
    ]);
  }



  // public function uploadImage(Request $request): ?string
  // {
  //     $imageUrl = "";
  //     if ($request->hasfile('default_image')) {

  //         $file = $request->file('default_image');
  //         $assetName = $request->input('title') . time();
  //         // generate a new filename. getClientOriginalExtension() for the file extension
  //         $filename =  $assetName . '.' . $file->getClientOriginalExtension();
  //         $imageUrl = 'machines/' . $filename;

  //         // save to storage/app/public/brands as the new $filename
  //         $image = Image::make($file);
  //         $image->save(storage_path('app/public/' . $imageUrl));
  //     }
  //     return $imageUrl;
  // }


  // public function uploadFile(Request $request): ?string
  // {

  //     $doc_file = "";
  //     if (!empty($request->file('report_document'))) {
  //         $fileName = time() . '.' . $request->file('report_document')->extension();
  //         $request->report_document->storeAs('public/documents/', $fileName);
  //         $doc_file = 'documents/' . $fileName;
  //     }
  //     return $doc_file;
  // }

  public function createSellMachine(array $userData): Sellmachine
  {
    $userData['item_code'] = $this->getReferenceNumber();

    $insert =  [
      'title'         => $userData['title'],
      'description'   => $userData['description'],
      'item_code'     => $userData['item_code'],
      'user_id'       => $userData['user_id'],
      'category_id'   => $userData['category_id'],
      'default_image' => $userData['default_image'],
      'brand_id'      => $userData['brand_id'],
      'country_id'    => $userData['country_id'],
      'is_capital'    => isset($userData['is_capital']) ? 1 : 0,
      'expected_price' => $userData['expected_price'],
      'yearof'        => $userData['yearof'],
      'modelno'       => $userData['modelno'],
      'usage'         => $userData['usage'],
      'location'       => $userData['location'],
      'serialno'       => $userData['serialno'],
      'available_country' => $userData['available_country'],
    ];


    if (!empty($userData['status'])) {
      $insert['status'] = $userData['status'];
    }
    $insert['slug'] = $this->createUniqueSlug($userData['title'], $userData['country_id'], $userData['brand_id'], $userData['modelno'], $userData['yearof']);

    if (isset($userData['meta_title']) && !empty($userData['meta_title'])) {
      $insert['meta_title'] = $userData['meta_title'];
    }
    if (isset($userData['keywords']) && !empty($userData['keywords'])) {
      $insert['keywords'] = $userData['keywords'];
    }
    if (isset($userData['meta_descriptions']) && !empty($userData['meta_descriptions'])) {
      $insert['meta_descriptions'] = $userData['meta_descriptions'];
    }

    $sellMachine = Sellmachine::create($insert);


    $sellMachineAgent = [
      'sell_machine_id' => $sellMachine->id,
      'agent_id'        => $userData['agent_id'],
      'sales_percent'   => '100'
    ];

    SellMachineAgent::create($sellMachineAgent);

    return $sellMachine;
  }

  public function uploadCatalog($input, $id)
  {
    // Save technical catalog
    // if (!empty($request->file('file_path'))) {
    //     $fileName = time() . '.' . $request->file('file_path')->extension();
    //     $request->file_path->storeAs('public/catalog/', $fileName);
    //     $doc_file = 'catalog/' . $fileName;

    $insert = [
      'sell_machine_id' => $id,
      'file_path'       => $input['file_path'],
      'file_type'       => 'technical'
    ];

    MachineCatalog::create($insert);
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

    $randStr =  "SM/" . date('y') . '/' . date('m') . '/' . $lastId;

    return $randStr;
  }

  public function createUniqueSlug($title, $countryId = null, $brand = null, $modelno = null, $yearof = null)
  {
    $query = SellMachine::where('title', 'like', $title);
    $existingRecord = $query->exists();
    if (!empty($title)) {
      $query->where('country_id', $countryId)
      ->where('title', 'like', $title);
      $existingCountRecord = $query->exists();
    }
    if (!empty($brand)) {
      $query->where('brand_id', $brand)
      ->where('title', 'like', $title);
      $existingBrandRecord = $query->exists();
    }
    if (!empty($modelno)) {
      $query->where('modelno', $modelno)
      ->where('title', 'like', $title);
      $existingModelRecord = $query->exists();
    }
    if (!empty($yearof)) {
      $query->where('yearof', $yearof)
      ->where('title', 'like', $title);
      $existingYearOfRecord = $query->exists();
    }
    $space = " ";

    // Build the slug
    if (!$existingRecord) {
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    } else if (!$existingCountRecord) {
      //$country = Country::find($input['country_id']);
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $countryId . $space . $title)));
    } else if (!$existingBrandRecord) {
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $brand . $space . $title)));
    } else if (!$existingModelRecord) {
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $modelno . $space . $title)));
    } else if (!$existingYearOfRecord) {
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $yearof . $space . $title)));
    } else {
      // Handle the case where no unique slug can be formed with title, country, or brand
      // You can implement a strategy here, such as appending a unique identifier
      $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',  uniqid() . $space . $title)));
    }

    return $slug;
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

    $catelogue =  MachineCatalog::where('sell_machine_id', $id)->first();
    return ($catelogue != "") ? $catelogue : $catalogue_null;
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
  public function deleteSpecification($id)
  {
    $sql = DB::table('machine_specifications')->where('id', $id);
    if ($sql->count() > 0) {
      $sql->delete();
      return true;
    }
    return false;
  }

  public function insertSellmachineimages(string $id, array $input)
  {

    $multiple_images = explode(",", $input['image_url']);

    if (!empty($multiple_images)) {
      $data = [];

      foreach ($multiple_images as $image) {

        $data = [
          'sell_machine_id'  => $id,
          'image_url'        => $image
        ];
        Sellmachineimage::insert($data);
      }
    }

    // $sellingMachineImages = [];
    // if (!empty($request->file('repeater-list'))) {

    //     foreach ($request->file('repeater-list') as $i => $ifile) {

    //         $imageUrl = '';

    //         if ($ifile['image_url']) {

    //             $file = $ifile['image_url'];

    //             $assetName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . time();

    //             $assetName = preg_replace("/\s+/", "-", $assetName);

    //             // generate a new filename. getClientOriginalExtension() for the file extension

    //             $filename =  $assetName . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

    //             $imageUrl = 'machines/' . $filename;
    //             // save to storage/app/public/teams as the new $filename

    //             $image = Image::make($file);

    //             $image->save(storage_path('app/public/' . $imageUrl));

    //             $sellingMachineImages[$i] = $imageUrl;
    //         }
    //     }
    // }



    // insert product models
    // if (isset($input["repeater-list"]) && !empty($input["repeater-list"])) {

    //     foreach ($input["repeater-list"] as $j => $nimage) {

    //         // get product models image

    //         $imageUrl = (isset($sellingMachineImages[$j]) && $sellingMachineImages[$j]) ? $sellingMachineImages[$j] : '';

    //         Sellmachineimage::insert([
    //             'sell_machine_id'  => $id,
    //             'image_url'        => $imageUrl

    //         ]);
    //     }
    // }
  }

  public function updateSellmachine(Sellmachine $sellmachine, array $userData): void
  {

    $update = [
      'title'         => $userData['title'],
      // 'slug'         => $userData['slug'],
      'description'   => $userData['description'],
      'item_code'     => $userData['item_code'],
      'user_id'       => $userData['user_id'],
      'category_id'   => $userData['category_id'],
      'default_image' => $userData['default_image'],
      'brand_id'      => $userData['brand_id'],
      'country_id'    => $userData['country_id'],
      'is_capital'    => isset($userData['is_capital']) ? 1 : 0,
      'expected_price' => $userData['expected_price'],
      'yearof'        => $userData['yearof'],
      'modelno'       => $userData['modelno'],
      'usage'         => $userData['usage'],
      'location'       => $userData['location'],
      'serialno'       => $userData['serialno'],
      'available_country' => $userData['available_country'],
    ];
    if (isset($userData['meta_title']) && !empty($userData['meta_title'])) {
      $update['meta_title'] = $userData['meta_title'];
    }
    if (isset($userData['keywords']) && !empty($userData['keywords'])) {
      $update['keywords'] = $userData['keywords'];
    }
    // $update['slug'] = $this->createUniqueSlug($userData['title'], $userData['country_id'], $userData['brand_id'], $userData['modelno'], $userData['yearof']);
    if (isset($userData['slug']) && !empty($userData['slug'])) {
      $update['slug'] = $userData['slug'];
    } else {
      $update['slug'] = $this->createUniqueSlug($userData['title'], $userData['country_id'], $userData['brand_id'], $userData['modelno'], $userData['yearof']);
    }
    if (isset($userData['meta_descriptions']) && !empty($userData['meta_descriptions'])) {
      $update['meta_descriptions'] = $userData['meta_descriptions'];
    }
    $sellmachine->update($update);

    $sellMachineAgentData = [
      'sell_machine_id' => $sellmachine->id,
      'agent_id'        => $userData['agent_id'],
      'sales_percent'   => '100'
    ];

    $sellMachineAgent = SellMachineAgent::where('sell_machine_id', $sellmachine->id)->first();

    if ($sellMachineAgent) {
      $sellMachineAgent->update($sellMachineAgentData);
    } else {
      SellMachineAgent::create($sellMachineAgentData);
    }

  }

  public function updateSellmachinestatus(string $id, Sellmachine $sellmachine, array $userData): void
  {
    $update = [

      'status'    => $userData['status'],
    ];


    $sellmachine->update($update);
  }

  public function deleteSellMachine(Sellmachine $sellmachine): void
  {
    // multiple images
    Sellmachineimage::where('sell_machine_id', $sellmachine->id)->delete();

    // delete catalog
    DB::table('machine_catalogs')->where('sell_machine_id', $sellmachine->id)->delete();

    // specifications
    DB::table('machine_specifications')->where('sell_machine_id', $sellmachine->id)->delete();

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
