<?php

namespace App\Http\Controllers\Product;

use App\Contracts\BrandInterface;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public $brandmodule;

    public function __construct(BrandInterface $brandmodule)
    {
       $this->brandmodule = $brandmodule;
    }

    public function list()
    {
        $brands = $this->brandmodule->getlist();
        return view('admin.brands.list', compact('brands'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            $reqData = [
                'title' => $request->title,
                'description' => $request->description,
                'department_id' => Auth::user()->department_id
            ];

            $brand = $this->brandmodule->add($reqData);

            if($brand) {

                return redirect()->back()->with('success', 'Brand Successfully Added');
            }
            return redirect()->back()->with('failed', 'Something Went Wrong! Please try again later');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }

    }

    public function edit($id)
    {
        try {
            $brand = Brand::find($id);
            $html = view('admin.brands.partials.edit_inner', compact('brand'))->render();

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
                'description' => $request->description
            ];

            $brand = $this->brandmodule->update($reqData);

            return response()->json([
                'success' => true,
                'message' => 'Brand Successfully Updated'
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
            $deleted = $this->brandmodule->destroy($id);

            if($deleted){
                return redirect()->back()->with('success', 'Brand Successfully Deleted');
            }

            return redirect()->back()->with('failed', 'Something Went Wrong! Please try again later');

        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }
    }




}
