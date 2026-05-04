<?php

namespace App\Http\Controllers\System;

use App\Contracts\DepartmentInterface;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public $department_module;

    public function __construct(DepartmentInterface $department_module)
    {
        $this->department_module = $department_module;
    }

    public function list()
    {
        $departments = $this->department_module->getlist();
        return view('admin.departments.list', compact('departments'));
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
                'title' => $request->title
            ];

            $this->department_module->add($reqData);

            return redirect()->back()->with('success', 'Department Successfully Added');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $department = Department::find($id);

            $html = view('admin.departments.partials.edit_inner', compact('department'))->render();

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
            ];

            $this->department_module->update($reqData);

            return response()->json([
                'success' => true,
                'message' => 'Department Successfully Updated'
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
            $this->department_module->destroy($id);

            return redirect()->back()->with('success', 'Department Successfully Deleted');

        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }
    }



}
