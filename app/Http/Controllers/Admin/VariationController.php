<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\VariationRequest;
use App\Http\Resources\VariationResource;
use App\Services\VariationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Response;

class VariationController extends AdminController
{
    public VariationService $variationService;

    public function __construct(VariationService $variationService)
    {
        parent::__construct();
        $this->variationService = $variationService;
        $this->middleware(['permission:variation'])->only('export');
        $this->middleware(['permission:variation_create'])->only('store');
        $this->middleware(['permission:variation_edit'])->only('update');
        $this->middleware(['permission:variation_delete'])->only('destroy');
    }

    // Show the list of variations with their types
    public function index(PaginateRequest $request)
    {
        try {
            $variations = $this->variationService->list($request);
            return VariationResource::collection($variations);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to fetch variations'], 422);
        }
    }

    // Store a new variation with its types
    public function store(VariationRequest $request)
    {
        try {
            $variation = $this->variationService->store($request);
            return new VariationResource($variation);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to create variation'], 422);
        }
    }

    // Update an existing variation and its types
    public function update(VariationRequest $request)
    {
        try {
            $variation = $this->variationService->update($request);
            return new VariationResource($variation);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to update variation'], 422);
        }
    }

    // Delete a variation and its types
    public function destroy(Request $request)
    {
        try {
            $this->variationService->destroy($request);
            return response()->json(['status' => true, 'message' => 'Variation deleted successfully'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to delete variation'], 422);
        }
    }
}
