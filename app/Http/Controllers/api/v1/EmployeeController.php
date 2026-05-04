<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $employee = new Employee();
            $employee->full_name = $request->full_name;
            $employee->employee_code = $request->employee_code;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->designation = $request->designation;
            $employee->department = $request->department;
            $employee->save();

            return response()->json([
                'success' => true,
                'message' => 'Employee Successfully Added',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }
}
