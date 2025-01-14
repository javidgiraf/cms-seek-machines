<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellmachineService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CountryService;
use App\Services\UserService;
use Mail;
use App\Mail\ReplySellingmachineAdStatusMail;
use App\Mail\ReportSendMail;
use App\Mail\VerifyAdMail;
use App\Models\User;
use App\Models\SellMachineAgent;
use Spatie\Permission\Models\Role;

class SellmachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getSellMachines();
        return view('sellmachines.index', compact('sellMachines'));
    }

    public function active(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getActiveSellMachines();
        return view('sellmachines.activesellmachines', compact('sellMachines'));
    }

    public function inactive(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getInActiveSellMachines();
        return view('sellmachines.inactivesellmachines', compact('sellMachines'));
    }

    public function pending(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getPendingSellMachines();
        return view('sellmachines.pendingsellmachines', compact('sellMachines'));
    }



    public function adVerificationSuccess(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getAdVerifySuccessSellMachines();
        return view('adverifications.success', compact('sellMachines'));
    }

    public function adVerificationFailed(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getAdVerifyFailedSellMachines();
        return view('adverifications.failed', compact('sellMachines'));
    }

    public function adVerificationPending(SellmachineService $sellmachineService)
    {
        //

        $sellMachines = $sellmachineService->getAdVerifyPendingSellMachines();

        return view('adverifications.pending', compact('sellMachines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BrandService $brandService, CategoryService $categoryService, UserService $userService, CountryService $countryService)
    {
        //
        $brands = $brandService->getAllBrands();
        $categories = $categoryService->categoryArray();
        $users = $userService->getCustomers();
        $countries = $countryService->getAllCountries();
        $seekAgentUsers = User::role('seekagent')->get();
        return view('sellmachines.create', compact('brands', 'categories', 'users', 'countries','seekAgentUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SellmachineService $sellmachineService)
    {
        //
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'user_id'       => 'required',
            'category_id'   => 'required',
            'country_id'    => 'required',
            'brand_id'      => 'required',
            'yearof'        => 'required',
            'modelno'       => 'required',
            'location'      => 'required',
            'agent_id'      => 'required',
            // 'default_image' => 'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        $input['status'] = 1;

        $machinead = $sellmachineService->createSellMachine($input);
        $id = $machinead->id;

        if (isset($input['spec_title']) && !empty($input['spec_title'])) {
            $sellmachineService->addSpecifications($input, $id);
        }

        if (isset($input['image_url']) && $input['image_url'] != '') {
            $sellmachineService->insertSellmachineimages($id, $input);
        }

        if (isset($input['file_path']) && $input['file_path'] != '') {
            $sellmachineService->uploadCatalog($input, $id);
        }

        return redirect()->route('sellmachines.index')->with('success', 'Sell Machine ad  created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(
        $id,
        SellmachineService $sellmachineService,
        BrandService $brandService,
        CategoryService $categoryService,
        UserService $userService,
        CountryService $countryService
    ) {
        //
        // $id = decrypt($id);
        $sellmachine = $sellmachineService->getSellMachine($id);
        $sellmachineimages = $sellmachineService->getSellMachineImages($id);
        $specifications = $sellmachineService->getSpecifications($id);
        $technicalpdf = $sellmachineService->getCatalogs($id);

        $brands = $brandService->getAllBrands();
        $categories = $categoryService->categoryArray();
        $users = $userService->getCustomers();
        $countries = $countryService->getAllCountries();
        $seekAgentUsers = User::role('seekagent')->get();
        $sellMachineAgent = SellMachineAgent::where('sell_machine_id',$id)->first();

        return view('sellmachines.edit', compact(
            'sellmachine',
            'sellmachineimages',
            'brands',
            'categories',
            'users',
            'countries',
            'specifications',
            'technicalpdf',
            'seekAgentUsers',
            'sellMachineAgent'

        ));
    }


    public function view(
        $id,
        SellmachineService $sellmachineService,
        BrandService $brandService,
        CategoryService $categoryService,
        UserService $userService,
        CountryService $countryService
    ) {
        //
        // $id = decrypt($id);
        $sellmachine = $sellmachineService->getSellMachine($id);
        $sellmachineimages = $sellmachineService->getSellMachineImages($id);
        $brands = $brandService->getBrands();
        $categories = $categoryService->getAllCategory();
        $type = 'customer';
        $users = $userService->getUsers($type);
        $countries = $countryService->getCountries();

        $specifications = $sellmachineService->getSpecifications($id);
        $technicalpdf = $sellmachineService->getCatalogs($id);



        return view('sellmachines.view', compact(
            'sellmachine',
            'sellmachineimages',
            'brands',
            'categories',
            'users',
            'countries',
            'specifications',
            'technicalpdf'
        ));
    }


    public function adVerificationView(
        $id,
        SellmachineService $sellmachineService,
        BrandService $brandService,
        CategoryService $categoryService,
        UserService $userService,
        CountryService $countryService
    ) {
        //
        // $id = decrypt($id);
        $sellmachine = $sellmachineService->getSellMachine($id);
        $sellmachineimages = $sellmachineService->getSellMachineImages($id);
        $seekAgentUsers = User::role('seekagent')->get();




        $email = $sellmachine->user->email;

   




        return view('adverifications.view', compact(
            'sellmachine',
            'sellmachineimages',
            'seekAgentUsers'


        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, SellmachineService $sellmachineService)
    {
        //
        $request->validate([
            'title'         => 'required',
            'slug'          => 'nullable|unique:sell_machines,slug,' . $id,
            'description'   => 'required',
            'user_id'       => 'required',
            'category_id'   => 'required',
            'country_id'    => 'required',
            'brand_id'      => 'required',
            'yearof'        => 'required',
            'modelno'       => 'required',
            'location'      => 'required',
            //'default_image' => 'required'
        ]);
        $input = $request->all();
        $sellmachine = $sellmachineService->getSellMachine($id);

        $sellmachineService->updateSellmachine($sellmachine, $input);

        if (isset($input['spec_title']) && !empty($input['spec_title'])) {
            $sellmachineService->addSpecifications($input, $id);
        }

        if (isset($input['image_url']) && $input['image_url'] != '') {
            $sellmachineService->insertSellmachineimages($id, $input);
        }

        if (isset($input['file_path']) && $input['file_path'] != '') {
            $sellmachineService->uploadCatalog($input, $id);
        }

        return redirect()->route('sellmachines.index')->with('success', 'Sell Machine ad updated successfully');
    }


    public function changestatus(Request $request, $id, SellmachineService $sellmachineService)
    {
        //
        // $id = decrypt($id);
        $request->validate([
            'status' => 'required',
        ]);
        //   $price_visible = isset($request->price_visible) ? 1 : 0;

        $input = $request->all();
        $sellmachine = $sellmachineService->getSellMachine($id);
        $email = $sellmachine->user->email;


        // $description_image_upload = $sellmachineService->uploadDescriptionImage($request);
        $sellmachineService->updateSellmachinestatus($id, $sellmachine, $input);
        ////$sellmachineService->insertSellmachineimages($id, $input, $request);

        //  $sellmachineService->updateCatalog($request, $id);

        //   $sellmachineService->addSpecifications($input, $id);

        $status = $input['status'];
         if ($status == 1) {
      $status_details = [
          'status_description' => 'Your Ad has been approved by the Admin',
          'status' => $status,
          'code'=>$sellmachine->item_code
      ];
        Mail::to($email)->send(new ReplySellingmachineAdStatusMail($status_details));
       }



        return redirect()->route('sellmachines.view', $id)->with('success', 'Status Changed for sell Machine ad');
    }

    public function verificationStatusUpdate(Request $request, $id, SellmachineService $sellmachineService)
    {
        $request->validate([
            'verified_on' => 'required',
            'isverified'  => 'required',
            'description' => 'required',
            'agent_id' => 'required'
        ]);

        $input = $request->all();

        $sellmachine = $sellmachineService->getSellMachine($id);
        $sellmachineService->insertReport($input, $sellmachine);
       // $sellmachine = SellMachine::find($id);
        $report_object = $sellmachineService->getReport($id);
        $report=$report_object->toArray();


        $user = $sellmachine->user;
     //   $boostad_details = $boostadd;
        switch ($input['isverified']) {
          case "1":
            $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Ad verfication has been Successful. Details are following',
        //    'image'=>$input,
            'user'=>$user,
            'sellmachine'=>$sellmachine,
            'data' => $report,
            'status' => "Success",
            'regards' => 'Seeko'

        ];
            break;
          case "0":
             $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Ad verfication has been Failed. Details are following',
           // 'image'=>$input,
            'user'=>$user,
            'sellmachine'=>$sellmachine,
            'data' => $report,
            'status' => "Failed",
            'regards' => 'Seeko'

        ];
            break;

          default:
             $customer_data = [
            'user_type'=>'Customer',
            'mail_text'=>'Your Ad verfication has been put under review. Details are following',
            'user'=>$user,
            'sellmachine'=>$sellmachine,
            'data' => $report,
            'status' => "On Review",
            'regards' => 'Seeko'

        ];
        }

        Mail::to($user->email)->send(new VerifyAdMail($customer_data));


        return redirect()->route('adverifications.verfication-view', $id)->with('success', 'Verification Status Updated Successfully');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, SellmachineService $sellmachineService)
    {
        $sellmachine = $sellmachineService->getSellMachine($id);

        // $sellmachineService->deleteImage($sellmachine->default_image);

        $sellmachineService->deleteSellMachine($sellmachine);

        // return redirect()->back()
        //     ->with('success', 'Sell Machine ad deleted successfully');

        return response()->json(array('success' => true, 'message' => 'Sell Machine ad deleted Successfully'));
    }

    public function deletesellMachineImage($id, SellmachineService $sellmachineService)
    {

        $sellmachineImage = $sellmachineService->getSellMachineImage($id);

        // $sellmachineService->deleteImage($sellmachineImage->image_url);
        $sellmachineService->deleteSellMachineImage($sellmachineImage);

        return response()->json([
            'data' => true
        ]);
    }
    public function deleteSpecifications($id, SellmachineService $sellmachineService)
    {
        try {
            $res = $sellmachineService->deleteSpecification($id);
            return response()->json(['success' => $res]);
        } catch (\Exception $e) {

            // throw new HttpException(500, );
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
