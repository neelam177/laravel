<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
// use Laravel\Pail\File;
use Illuminate\Support\Facades\File;


class EmployeeController extends Controller
{
    public function index()
    {
        // echo "this is just foe testing";
        // $employee = Employee::orderBy('id' , 'DESC')->get();
        $employee = Employee::orderBy('id', 'DESC')->paginate(5);
        return view('employee.list', ['employee' => $employee]);
    }
    public function create()
    {
        return view('employee.create');
    }
    // Handling requests from users.
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image|mimes:gif,png,jpeg,jpg'
        ]);
        if ($validator->passes()) {
            //save data here
            // Here Employee is the model class of Laravel.
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            if ($request->image) {
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $ext;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName);
                $employee->image = $newFileName;
                $employee->save();
            }
            // Success message
            $request->session()->flash('success', 'Employee Added Successfully.');
            // flash shows a success message only once after redirect.
            return redirect()->route('employees.index');
        } else {
            //return error here
            return redirect()->route('employees.create')
                ->withErrors($validator)
                ->withInput();
        }
        // "this line redirects the user back to the form with validation errors and previous input data."
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', ['employee' => $employee]);
    }
    public function update($id, Request $request) {

         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image|mimes:gif,png,jpeg,jpg'
        ]);
        if ($validator->passes()) {
            //save data here
            // Here Employee is the model class of Laravel.
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            if ($request->image) {
                $oldImage = $employee->image;
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $ext;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName);
                $employee->image = $newFileName;
                $employee->save();

                File::delete(public_path() . '/uploads/employees/'.'$oldImage');
            }
            // Success message
            $request->session()->flash('success', 'Employee Added Successfully.');
            // flash shows a success message only once after redirect.
            return redirect()->route('employees.index');
        } else {
            //return error here
            return redirect()->route('employees.create')
                ->withErrors($validator)
                ->withInput();
        }
    }
}
