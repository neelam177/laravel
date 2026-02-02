<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Student extends Controller
{
    /**
     * Display a listing of students
     */
    public function index()
    {
        $students = Employee::orderBy('id', 'DESC')->get();
        
        return response()->json([
            'status' => 200,
            'message' => 'Students retrieved successfully',
            'data' => $students
        ], 200);
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:3|max:191',
            'email'   => 'required|email|max:191',
            'address' => 'required|max:191',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validation failed',
                'errors'  => $validator->messages()
            ], 422);
        } else {
            // Save to database
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/employees'), $imageName);
                $employee->image = $imageName;
            }
            
            $employee->save();
            
            return response()->json([
                'status'  => 201,
                'message' => 'Student created successfully',
                'data'    => $employee
            ], 201);
        }
    }

    /**
     * Display the specified student
     */
    public function show($id)
    {
        $student = Employee::find($id);
        
        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Student retrieved successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, $id)
    {
        $student = Employee::find($id);
        
        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:3|max:191',
            'email'   => 'required|email|max:191',
            'address' => 'required|max:191',
            'image'   => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validation failed',
                'errors'  => $validator->messages()
            ], 422);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->address = $request->address;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($student->image && file_exists(public_path('uploads/employees/' . $student->image))) {
                unlink(public_path('uploads/employees/' . $student->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/employees'), $imageName);
            $student->image = $imageName;
        }
        
        $student->save();
        
        return response()->json([
            'status'  => 200,
            'message' => 'Student updated successfully',
            'data'    => $student
        ], 200);
    }

    /**
     * Remove the specified student
     */
    public function destroy($id)
    {
        $student = Employee::find($id);
        
        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
        
        // Delete image if exists
        if ($student->image && file_exists(public_path('uploads/employees/' . $student->image))) {
            unlink(public_path('uploads/employees/' . $student->image));
        }
        
        $student->delete();
        
        return response()->json([
            'status' => 200,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}