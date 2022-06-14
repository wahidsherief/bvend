<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorAccount\VendorStoreRequest;
use App\Http\Requests\VendorAccount\VendorUpdateRequest;
use App\Http\Requests\VendorAccount\MachineStoreRequest;
use App\Http\Requests\VendorAccount\MachineUpdateRequest;
use App\Repositories\VendorRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\BaseService;
use App\Services\MachineService;
use App\Services\TransactionService;

class VendorAccountController extends Controller
{
    private $path = 'vendor'; // path to upload images

    protected $service;
    protected $machine_service;
    protected $transaction_service;
    protected $vendor;
    protected $productcategory;
    protected $product;

    public function __construct(
        BaseService $service,
        MachineService $machine_service,
        TransactionService $transaction_service,
        VendorRepository $vendor,
        ProductCategoryRepository $productcategory,
        ProductRepository $product
    ) {
        $this->middleware('auth:admin');
        $this->service = $service;
        $this->machine_service = $machine_service;
        $this->transaction_service = $transaction_service;
        $this->vendor = $vendor;
        $this->productcategory = $productcategory;
        $this->product = $product;
    }

    public function index()
    {
        $vendors = $this->vendor->get();

        return view('vendor_account.index')->with('vendors', $vendors);
    }

    public function active()
    {
        $vendors = $this->vendor->active();

        return view('vendor_account.active', compact('vendors'));
    }

    public function inactive()
    {
        $vendors = $this->vendor->inactive();

        return view('vendor_account.active', compact('vendors'));
    }

    public function create()
    {
        return view('vendor_account.create');
    }

    public function store(VendorStoreRequest $request)
    {
        $attributes = $this->service->processInputForStore($request->all(), $this->path);

        $stored = $this->vendor->store($attributes);

        if (!$stored) {
            return redirect()->route('vendor_account_inactive')->with('danger', 'Vendor account creation failed!');
        }

        return redirect()->route('vendor_account_inactive')->with('warning', 'Vendor account submitted for Approval!');
    }

    public function show($id)
    {
        $vendor = $this->vendor->find($id);

        $transactions = $this->transaction_service->getAllTransactionsOfVendor($vendor->id, 15);

        if (!$vendor) {
            return abort(404);
        }

        return view('vendor_account.show', compact('vendor', 'transactions'));
    }

    public function edit($id)
    {
        $vendor = $this->vendor->find($id);

        return view('vendor_account.edit')->with('vendor', $vendor);
    }

    public function update(VendorUpdateRequest $request, $id)
    {
        $vendor = $this->vendor->find($id);

        $attributes = $this->service->processInputForUpdate($vendor, $request->all(), $this->path);

        $updated = $this->vendor->update($id, $attributes);

        if (!$updated) {
            return redirect()->route('vendor_account_active')->with('danger', 'Vendor account update failed!');
        }

        return redirect()->route('vendor_account_active')->with('success', 'Vendor account updated successfully!');
    }

    public function destroy($id)
    {
        $vendor = $this->vendor->find($id);

        $this->service->deleteImage($vendor, $this->path);

        $destroyed = $this->vendor->delete($id);

        if (!$destroyed) {
            return redirect()->back()->with('error', 'Vendor account delete failed !');
        }

        return redirect()->route('vendor_account.inactive')->with('success', 'Vendor account deleted Succesfully!');
    }

    // vendor account activate / deactivate method
    public function toggleVendor($id)
    {
        $vendor = $this->vendor->find($id);

        $attributes = [];

        if ($vendor->is_approved == 1) {
            $attributes['is_approved'] = 0;

            $this->vendor->update($id, $attributes);

            return redirect()->route('vendor_account_active')->with('success', 'Vendor account dectivated!');
        } else {
            $attributes['is_approved'] = 1;

            $this->vendor->update($id, $attributes);

            return redirect()->route('vendor_account_active')->with('success', 'Vendor account activated!');
        }
    }

    public function getMachine($vendor_id)
    {
        $machines = $this->machine_service->getAllMachinesOfVendor($vendor_id);

        return view('vendor_account.machine', compact('vendor_id', 'machines'));
    }

    public function showMachine($vendor_id, $machine_id)
    {
        $machine = $this->machine_service->getSpecificMachineOfVendor($vendor_id, $machine_id);

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor_account.machine_show')->with(['vendor' => $vendor, 'machine' => $machine]);
    }

    public function createMachine($vendor_id)
    {
        $categories = $this->productcategory->all();

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor_account.machine_create')->with(['vendor' => $vendor, 'categories' => $categories]);
    }

    public function saveMachine(MachineStoreRequest $request)
    {
        $stored = $this->machine_service->store($request);

        if (!$stored) {
            return redirect()->back()->with('error', 'There is something wrong! Please try again.');
        }

        return redirect()->back()->with('success', 'A machine with ' . $request->model . ' Lockers created successfully');
    }

    public function editMachine($vendor_id, $machine_id)
    {
        $vendor = $this->vendor->find($vendor_id);

        $categories = $this->productcategory->all();

        $machine = $this->machine_service->getSpecificMachineOfVendor($vendor_id, $machine_id);

        return view('vendor_account.machine_edit')->with(['vendor' => $vendor, 'categories' => $categories, 'machine' => $machine]);
    }

    public function updateMachine(MachineUpdateRequest $request)
    {
        $machine_service = new MachineService;

        $updated = $machine_service->update($request);

        if (!$updated) {
            return redirect()->back()->with('failure', 'Machine info update failed!');
        }

        return redirect()->back()->with('success', 'Machine info updated!');
    }

    // locker machine activate / deactivate method
    public function toggleMachineActivation($vendor_id, $machine_id)
    {
        $machine = $this->machine_service->getSpecificMachineOfVendor($vendor_id, $machine_id);

        if ($machine->active == 1) {
            $attributes['active'] = 0;

            $updated = $machine_service->toggleMachineActivation($machine_id, $attributes);

            if (!$updated) {
                return redirect()->back()->with('failure', 'Machine dectivation failed!');
            }

            return redirect()->back()->with('success', 'Machine dectivated!');
        } else {
            $attributes['active'] = 1;

            $updated = $machine_service->toggleMachineActivation($machine_id, $attributes);

            if (!$updated) {
                return redirect()->back()->with('failure', 'Machine activation failed!');
            }

            return redirect()->back()->with('success', 'Machine activated!');
        }
    }
}
