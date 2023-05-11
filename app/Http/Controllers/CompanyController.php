<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        //
        return CompanyResource::collection(Company::paginate());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return Response
     */
    public function store(StoreCompanyRequest $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_industry'=> 'required',
            'company_address' => 'required',
            'company_location' => 'required',
            'company_size' => 'required'
        ]);

        if ($validator->fails()) {
            return response((['error' => $validator->errors(), 'status'=> 404]));
        }else{
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $data['company_industry'] = implode(',', $request['company_industry']);
            return Company::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return Response
     */
    public function show(Company $company)
    {
        //
        return response($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return Application|ResponseFactory|Response
     */
    public function upload(UpdateCompanyRequest $request, Company $company)
    {

        if ($request->user()->id != $company->user_id){
            return response(["user_id"=> $company->user_id, "request_id"=> request()->user()->id]);
        }
        if (!$request->hasFile('logo')){
            return abort(404);
        }
        $destination_path = 'public/images/logos';
        $image = $request->file('logo');
        $imageName = "$company->id.".$image->getClientOriginalExtension();
        $path = $request->file('logo')->storeAs($destination_path, $imageName);

        $company->update($request->all());
        $company->logo_path = asset('/storage/images/logos/'.$imageName);
        $company->save();
        return response(["company"=>$company, 'path'=>asset($path)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return Response
     */
    public function destroy(Request $request, Company $company)
    {
        //
        if ($request->user()->user_id != $company->getAttribute('user_id')){
            return abort(403);
        }
        $company->delete();
        return response(["message"=> "company deleted successfully"]);
    }

    public function search($name){
        return Company::where('name', 'like', '%'.$name.'%')->all();
    }
}
