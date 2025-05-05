<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Response;

class SupplierController extends AdminController
{
    public SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        parent::__construct();
        $this->supplierService = $supplierService;
        $this->middleware(['permission:supplier'])->only('export');
        $this->middleware(['permission:supplier_create'])->only('store');
        $this->middleware(['permission:supplier_edit'])->only('update');
        $this->middleware(['permission:supplier_delete'])->only('destroy');
    }

    public function index(PaginateRequest $request)
    {
        try {
            return SupplierResource::collection($this->supplierService->list($request));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to fetch supplier'], 422);
        }
    }

    public function store(SupplierRequest $request)
    {
        try {
            $supplier =  $this->supplierService->store($request);
            return new SupplierResource($supplier);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to create supplier'], 422);
        }
    }

    public function update(SupplierRequest $request)
    {
        try {
            $supplier = $this->supplierService->update($request);
            return new SupplierResource($supplier);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to update supplier'], 422);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->supplierService->destroy($request);
            return response()->json(['status' => true, 'message' => 'Supplier deleted successfully'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to delete Supplier'], 422);
        }
    }
}
