<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Vinkla\Hashids\Facades\Hashids;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Employee $model)
    {
        return view('employees.list', ['employees' => $model->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $companies = Company::get();
        return view('employees.create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'company_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            //'email' => 'required',            
            //'phone' => 'required',            
        ]);

        if ($request->isMethod('post')){

            $employee = new Employee;
            $employee->company_id = $request->input('company_id');
            $employee->first_name = $request->input('first_name');
            $employee->last_name  = $request->input('last_name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->save();

            return redirect()->route('employees')->withStatus(__('Employee successfully created.'));
        }else{
            return redirect()->route('employee.create')->withError(__('Invalid form entry'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Hashids::decode($id)[0];

        $employee  = Employee::findOrFail($id);      
        $companies = Company::get();  
        return view('employees.edit', ['employee' => $employee, 'companies' => $companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request,[
            'company_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            //'email' => 'required',            
            //'phone' => 'required',            
        ]);

        if ($request->isMethod('post')){

            $id   = Hashids::decode($request->input('employee_id'))[0];
            $employee = Employee::findOrFail($id);
            if( $employee ){  
                $employee->company_id = $request->input('company_id');
                $employee->first_name = $request->input('first_name');
                $employee->last_name  = $request->input('last_name');
                $employee->email = $request->input('email');
                $employee->phone = $request->input('phone');
                $employee->save();

                return redirect()->route('employees')->withStatus(__('Employee successfully updated.'));
            }
        }

        return redirect()->route('employee.edit', Hashids::encode($employee
            ->id))->withError(__('Invalid form entry'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Hashids::decode($id)[0];
        $employee = Employee::findOrFail($id);
        if($employee) { 
            $employee->delete();

            return redirect()->route('employees')->withStatus(__('Employee deleted successfully'));
        }
    }
}
