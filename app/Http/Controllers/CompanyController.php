<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Vinkla\Hashids\Facades\Hashids;

class CompanyController extends Controller
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
    public function index(Company $model)
    {
        return view('companies.list', ['companies' => $model->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('companies.create', []);
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
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'name' => 'required',
            'email' => 'required',            
        ]);

        if ($request->isMethod('post')){

            $imageName = time().'.'.$request->logo->extension();
            $request->logo->storeAs('public/images', $imageName);

            $company = new Company;
            $company->name    = $request->input('name');
            $company->email   = $request->input('email');
            $company->logo    = $imageName;
            $company->website = $request->input('website');
            $company->save();

            return redirect()->route('companies')->withStatus(__('Company successfully created.'));
        }else{
            return redirect()->route('company.create')->withError(__('Invalid form entry'));
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

        $company  = Company::findOrFail($id);        
        return view('companies.edit', ['company' => $company]);
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
        $this->validate($request,[
            //'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100',
            'name' => 'required',
            'email' => 'required',            
        ]);

        if ($request->isMethod('post')){

            $id   = Hashids::decode($request->input('company_id'))[0];
            $company = Company::findOrFail($id);
            if( $company ){
                if ($request->hasFile('logo')) {
                    $imageName = time().'.'.$request->logo->extension();
                    $request->logo->storeAs('public/images', $imageName);

                    Storage::delete('public/images/'.$company->logo);
                }else{
                    $imageName = $company->logo;
                }

                $company->name    = $request->input('name');
                $company->email   = $request->input('email');
                $company->logo    = $imageName;
                $company->website = $request->input('website');
                $company->save();

                return redirect()->route('companies')->withStatus(__('Company successfully updated.'));
            }
        }

        return redirect()->route('company.edit', Hashids::encode($company
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
        $company = Company::findOrFail($id);
        if($company) { 
            if(Storage::delete('public/images/'.$company->logo)) {
                $company->delete();
            }            
            return redirect()->route('companies')->withStatus(__('Company deleted successfully'));
        }
    }
}
