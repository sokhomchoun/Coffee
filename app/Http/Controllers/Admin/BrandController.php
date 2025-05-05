<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Requests\PaginateRequest;
use Response;

class BrandController extends AdminController
{
    public BrandService $BrandService;

    public function __construct(BrandService $brandService)
    {
        parent::__construct();
        $this->brandService = $brandService;
        $this->middleware(['permission:brand'])->only('export');
        $this->middleware(['permission:brand_create'])->only('store');
        $this->middleware(['permission:brand_edit'])->only('update');
        $this->middleware(['permission:brand_delete'])->only('destroy');

    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return BrandResource::collection($this->brandService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(BrandRequest $request): \Illuminate\Http\Response | BrandResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new BrandResource($this->brandService->store($request));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(BrandRequest $request, Brand $item): \Illuminate\Http\Response | BrandResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new BrandResource($this->brandService->update($request, $item));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy($id) {
        try {
            Brand::where('id', $id)->delete();
            return response()->json([
                'success' => true,
            ], 201);
        } catch (Exception $exception) {
            return response(['status' => false,'message' => $exception->getMessage()], 422);
        }
    }

}
