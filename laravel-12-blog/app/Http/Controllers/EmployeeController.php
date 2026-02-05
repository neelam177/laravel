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
            #option1
            // Here Employee is the model class of Laravel.
            // $employee = new Employee();
            // $employee->name = $request->name;
            // $employee->email = $request->email;
            // $employee->address = $request->address;
            // $employee->save();

            #option2
            // $employee = new Employee();
            // $employee->fill($request->post())->save();

            #option3
            $employee = Employee::create($request->post());

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
    public function edit(Employee $employee)
    {
        // $employee = Employee::findOrFail($id);
        return view('employee.edit', ['employee' => $employee]);
    }
    public function update(Employee $employee, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image|mimes:gif,png,jpeg,jpg'
        ]);
        if ($validator->passes()) {
            //save data here
            // Here Employee is the model class of Laravel.
            #option1
            // $employee = Employee::find($id);
            // $employee->name = $request->name;
            // $employee->email = $request->email;
            // $employee->address = $request->address;
            // $employee->save();

            #opetion2
            $employee->fill($request->post())->save();

            if ($request->image) {
                $oldImage = $employee->image;
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $ext;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName);
                $employee->image = $newFileName;
                $employee->save();

                File::delete(public_path() . '/uploads/employees/' . '$oldImage');
            }
            // Success message
            // $request->session()->flash('success', 'Employee Updated Successfully.');
            // flash shows a success message only once after redirect.
            return redirect()->route('employees.index')->with('success', 'Employee Updated Successfully.');
        } else {
            //return error here
            // return redirect()->route('employees.create')
            //     ->withErrors($validator)
            //     ->withInput();
            return redirect()->route('employees.edit', $employee->id)->withErrors($validator)->withInput();
        }
    }
    public function destroy(Request $request, Employee $employee)
    {
        // $employee = Employee::findOrFail($id);

        // Delete image if exists
        if ($employee->image && File::exists(public_path() . '/uploads/employees/' . $employee->image)) {
            File::delete(public_path() . '/uploads/employees/' . $employee->image);
        }
        $employee->delete();
        // $request->session()->flash('success', '');
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }


    // API method to return employees as JSON
    function list()
    {
        return Employee::all();
    }
    function addEmployee(Request $request)
    {
        // return "hello here";
        // return $request->input();
        $rules = array(
            'name' => 'required | min:3 |max:10',
            'email'=>'email | required',
            'address'=> 'required'
        );
        $validatoin = validator::make($request->all(), $rules);
        if ($validatoin->fails()) {
            return $validatoin->errors();
        } else {
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            if ($employee->save()) {
                // return "Employee Added";
                return ["result" => "Employee Added"];
            } else {
                // return "operation failed";
                return ["result" => "Employee failed"];
            }
        }
    }
    function updateEmpoyee(Request $request)
    {
        // return "updated Employee";
        $employee = Employee::find($request->id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        if ($employee->save()) {
            // return "Employee Added";
            return ["result" => "Employee Updeted"];
        } else {
            // return "operation failed";
            return ["result" => "Employee not Updeted"];
        }
    }
    function deleteEmployee($id)
    {
        // return $id ;
        $employee = Employee::destroy($id);
        if ($employee) {
            return ['result' => "Employee deleted record"];
        } else {
            return ['result' => "Employee record not deleted"];
        }
    }
}
