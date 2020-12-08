<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorAccount\VendorStoreRequest;
use App\Http\Requests\VendorAccount\VendorUpdateRequest;
use App\Http\Requests\VendorAccount\MachineStoreRequest;
use App\Http\Requests\VendorAccount\MachineUpdateRequest;
use App\Repositories\VendorRepository;
use App\Repositories\ProductCategoryRepository;
use App\Services\BaseService;
use App\Services\MachineService;
use App\Services\TransactionService;

class VendorAccountController extends Controller
{
    private $path = 'vendor'; // path to upload images

    protected $vendor;
    protected $service;
    protected $machine_service;

    public function __construct(VendorRepository $vendor, BaseService $service, MachineService $machine_service)
    {
        $this->middleware('auth:admin');
        $this->vendor = $vendor;
        $this->service = $service;
        $this->machine_service = $machine_service;
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

    public function show($id, TransactionService $transaction_service)
    {
        $vendor = $this->vendor->find($id);

        $transactions = $transaction_service->getAllLockerMachineTransactionsOfThisVendor($vendor->id, 15);

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

    public function getLockerMachine($vendor_id)
    {
        $machines_with_models = $this->machine_service->getAllLockerMachinesOfThisVendor($vendor_id);

        return view('vendor_account.machine_locker', compact('vendor_id', 'machines_with_models'));
    }

    public function showLockerMachine($vendor_id, $model, $machine_id)
    {
        $machine = $this->machine_service->getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id);

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor_account.machine_locker_show')->with(['vendor' => $vendor, 'machine' => $machine]);
    }

    public function createLockerMachine($vendor_id, ProductCategoryRepository $productcategory)
    {
        $categories = $productcategory->all();

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor_account.machine_locker_create')->with(['vendor' => $vendor, 'categories' => $categories]);
    }

    public function storeLockerMachine(MachineStoreRequest $request)
    {
        $stored = $this->machine_service->store($request);

        if (!$stored) {
            return redirect()->back()->with('error', 'There is something wrong! Please try again.');
        }

        return redirect()->back()->with('success', 'A machine with ' . $request->model . ' Lockers created successfully');
    }

    public function editLockerMachine($vendor_id, $model, $machine_id, ProductCategoryRepository $productcategory)
    {
        $vendor = $this->vendor->find($vendor_id);

        $categories = $productcategory->all();

        $machine = $this->machine_service->getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id);

        return view('vendor_account.machine_locker_edit')->with(['vendor' => $vendor, 'categories' => $categories, 'machine' => $machine]);
    }

    public function updateLockerMachine(MachineUpdateRequest $request)
    {
        $machine_service = new MachineService;

        $updated = $machine_service->update($request);

        if (!$updated) {
            return redirect()->back()->with('failure', 'Machine info update failed!');
        }

        return redirect()->back()->with('success', 'Machine info updated!');
    }

    // locker machine activate / deactivate method
    public function toggleLockerMachine($vendor_id, $model, $machine_id)
    {
        $machine_service = new MachineService;

        $machine = $machine_service->getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id);

        if ($machine->active == 1) {
            $attributes['active'] = 0;

            $updated = $machine_service->toggleMachine($model, $machine_id, $attributes);

            if (!$updated) {
                return redirect()->back()->with('failure', 'Machine dectivation failed!');
            }

            return redirect()->back()->with('success', 'Machine dectivated!');
        } else {
            $attributes['active'] = 1;

            $updated = $machine_service->toggleMachine($model, $machine_id, $attributes);

            if (!$updated) {
                return redirect()->back()->with('failure', 'Machine activation failed!');
            }

            return redirect()->back()->with('success', 'Machine activated!');
        }
    }
}
