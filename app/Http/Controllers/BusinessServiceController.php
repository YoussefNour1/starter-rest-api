<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessServiceStoreRequest;
use App\Http\Requests\BusinessServiceUpdateRequest;
use App\Http\Resources\BusinessServiceResource;
use App\Models\BusinessService;
use Illuminate\Http\Request;

class BusinessServiceController extends Controller
{
    //
    function index()
    {
        $businessServices = BusinessService::with('company')->paginate();
        return BusinessServiceResource::collection($businessServices);
    }

    function store(BusinessServiceStoreRequest $request)
    {
        $service = BusinessService::create($request->validated());
        $service->load('company');
        return new BusinessServiceResource($service);
    }

    public function show($id)
    {
        $businessService = BusinessService::with('company')->findOrFail($id);

        return new BusinessServiceResource($businessService);
    }

    public function update(BusinessServiceUpdateRequest $request, $id)
    {
        $businessService = BusinessService::findOrFail($id);
        $businessService->update($request->validated());
        $businessService->load('company');
        return new BusinessServiceResource($businessService);
    }

    // Search business services with pagination
    public function search(Request $request)
    {
        $query = $request->input('query');
        $services = BusinessService::with('company')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhereHas('company', function ($companyQuery) use ($query) {
                $companyQuery->where('company_name', 'LIKE', "%{$query}%");
            })->paginate();

        // Debugging
        //dd($services->toSql(), $services->getBindings());


        return BusinessServiceResource::collection($services);
    }

    // Delete a business service
    public function destroy($id)
    {
        $businessService = BusinessService::findOrFail($id);
        $businessService->delete();

        return response()->json(['message' => 'Business service deleted successfully']);
    }

}
