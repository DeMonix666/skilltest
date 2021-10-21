<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('employee', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_id' => 'required|exists:App\Models\Company,id',
        ]);

        try
        {
            Employee::create($request->all());

            return response()->json(['success' => 'Successfully added'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $employee->toJson()], 200);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_id' => 'required'
        ]);

        try
        {
            $employee = Employee::findOrFail($employee->id);
            $employee->firstname  = $request->firstname;
            $employee->lastname   = $request->lastname;
            $employee->email      = $request->email;
            $employee->phone      = $request->phone;
            $employee->company_id = $request->company_id;
            $employee->update();

            return response()->json(['success' => 'successfully updated'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Employee::destroy($id);

            return response()->json(['success' => 'successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function list()
    {
        try
        {
            $employee = DB::table('employees')
            ->leftJoin('companies', 'companies.id', '=', 'employees.company_id')
            ->select(['employees.id', 'firstname', 'lastname', 'employees.email', 'phone', 'company_id', 'companies.name AS company_name'])
            ->get();
                

            return DataTables::of($employee)
                ->addColumn('action', function ($employee) {
                    return '<button employee_id="' . 
                        $employee->id . '" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</button> <button employee_id="' . 
                        $employee->id . '" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
