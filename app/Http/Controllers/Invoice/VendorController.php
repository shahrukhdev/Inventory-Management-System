<?php

namespace App\Http\Controllers\Invoice;

use App\Contracts\VendorInterface;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public $vendormodule;

    public function __construct(VendorInterface $vendormodule)
    {
        $this->vendormodule = $vendormodule;
    }

    public function list()
    {
        $vendors = $this->vendormodule->getlist();
        return view('admin.vendors.list', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            $reqData = [
                'title' => $request->title,
                'address' => $request->address,
                'department_id' => Auth::user()->department_id
            ];

            $vendor = $this->vendormodule->add($reqData);

            if($vendor) {

                return redirect()->back()->with('success', 'Vendor Successfully Added');
            }
            return redirect()->back()->with('failed', 'Something Went Wrong! Please try again later.');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());

        }

    }

    public function edit($id)
    {
        try {
            $vendor = Vendor::find($id);

            $html = view('admin.vendors.partials.edit_inner', compact('vendor'))->render();

            return response()->json([
                'success' => true, 'html' => $html
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error'=>$validator->errors()->all()], 500);
        }

        try {
            $reqData = [
                'id' => $id,
                'title' => $request->title,
                'address' => $request->address,
                'department_id' => Auth::user()->department_id
            ];

            $vendor = $this->vendormodule->update($reqData);

            return response()->json([
                'success' => true,
                'message' => 'Vendor Successfully Updated'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $deleted = $this->vendormodule->destroy($id);
            if($deleted){
                return redirect()->back()->with('success', 'Vendor Successfully Deleted');
            }
            return redirect()->back()->with('failed', 'Something Went Wrong! Please try again later.');

        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

}
