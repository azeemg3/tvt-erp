<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.index');
    }

    /**
     * Show the company setup form (single, editable company profile).
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::current();

        return view('companies.create', compact('company'));
    }

    /**
     * Store / update the company profile.
     *
     * The company profile is a single record, so we upsert onto the first row.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateCompany($request);

        $company = Company::query()->orderBy('id')->first() ?: new Company();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLogo($request->file('logo'));
        } else {
            unset($data['logo']);
        }

        $company->fill($data);
        $company->save();

        Company::flushCurrent();

        return redirect()
            ->route('company_setup.create')
            ->with('success', 'Company setup has been saved successfully.');
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
    public function edit($id)
    {
        return $this->create();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validateCompany($request);

        $company = Company::query()->findOrNew($id);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLogo($request->file('logo'));
        } else {
            unset($data['logo']);
        }

        $company->fill($data);
        $company->save();

        Company::flushCurrent();

        return redirect()
            ->route('company_setup.create')
            ->with('success', 'Company setup has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate the incoming company profile payload.
     */
    protected function validateCompany(Request $request): array
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_mobile' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'govt_lic_no' => ['nullable', 'string', 'max:100'],
            'iata_no' => ['nullable', 'string', 'max:100'],
            'ntn' => ['nullable', 'string', 'max:100'],
            'powered_by' => ['nullable', 'string', 'max:255'],
            'contact_no' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp,svg', 'max:2048'],
        ]);
    }

    /**
     * Store an uploaded logo into the public assets directory and return the
     * relative asset path (matching how existing templates reference images).
     */
    protected function storeLogo($file): string
    {
        $directory = public_path('dist/img');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = $file->getClientOriginalExtension() ?: 'png';
        $filename = 'company-logo-' . time() . '.' . $extension;

        $file->move($directory, $filename);

        return 'public/dist/img/' . $filename;
    }
}
