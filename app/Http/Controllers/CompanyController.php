<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
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
        return view('company');
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
            'name' => 'required',
            'email' => 'required|email',
            'logo'  => 'nullable|sometimes|image|mimes:jpg,png|max:2048',
        ]);

        try
        {
            // Company::create($request->all());
            $company = new Company;
            $company->name = $request->name;
            $company->email = $request->email;

            $logo = $request->file('logo');

            if ($logo){
                $filename = time().'_'. preg_replace("/\s+/", "_", $logo->getClientOriginalName()) ;

                $logo->move('uploads/company', $filename);

                $company->logo = $filename;
            }

            $company->save();

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
    public function edit(Company $company)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $company->toJson()], 200);

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
    public function update(Request $request, Company $company)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'logo'  => 'sometimes|mimes:jpg,png|max:2048',
        ]);

        try
        {
            $company = Company::findOrFail($company->id);
            $company->name = $request->name;
            $company->email = $request->email;

            $logo = $request->file('logo');

            if ($logo){
                $filename = time().'_'. preg_replace("/\s+/", "_", $logo->getClientOriginalName()) ;
                // $path = $request->file('logo')->store('public/company');

                $logo->move('uploads/company', $filename);

                $company->logo = $filename;
            }

            $company->update();

            return response()->json(['success' => 'Successfully updated'], 200);
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
            Company::destroy($id);

            return response()->json(['success' => 'successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function list()
    {
        try
        {
            $company = Company::select(['id', 'name', 'email', 'logo']);

            return DataTables::of($company)
                ->addColumn('action', function ($company) {
                    return '<button company_id="' . 
                        $company->id . '" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</button> <button company_id="' . 
                        $company->id . '" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
