<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\UnitResource;
use App\Http\Requests\PaginateRequest;
use Response;

class UnitController extends AdminController
{
    public UnitService $UnitService;

    public function __construct(UnitService $unitService)
    {
        parent::__construct();
        $this->unitService = $unitService;
        $this->middleware(['permission:unit'])->only('export');
        $this->middleware(['permission:unit_create'])->only('store');
        $this->middleware(['permission:unit_edit'])->only('update');
        $this->middleware(['permission:unit_delete'])->only('destroy');

    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return UnitResource::collection($this->unitService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(UnitRequest $request): \Illuminate\Http\Response | UnitResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new UnitResource($this->unitService->store($request));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(UnitRequest $request, Unit $item): \Illuminate\Http\Response | UnitResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new UnitResource($this->unitService->update($request, $item));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy($id) {
        try {
            Unit::where('id', $id)->delete();
            return response()->json([
                'success' => true,
            ], 201);
        } catch (Exception $exception) {
            return response(['status' => false,'message' => $exception->getMessage()], 422);
        }
    }

}
