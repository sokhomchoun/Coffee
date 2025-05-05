<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\PurchaseOrdersRequest;
use App\Http\Resources\PurchaseOrdersResource;
use App\Services\PurchaseOrdersService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Response;

class PurchaseOrdersController extends AdminController
{
    public PurchaseOrdersService $purchaseOrdersService;

    public function __construct(PurchaseOrdersService $purchaseOrdersService)
    {
        parent::__construct();
        $this->purchaseOrdersService = $purchaseOrdersService;
        $this->middleware(['permission:purchase_orders'])->only('export');
        $this->middleware(['permission:purchase_orders_create'])->only('store');
        $this->middleware(['permission:purchase_orders_edit'])->only('update');
        $this->middleware(['permission:purchase_orders_delete'])->only('destroy');
    }

    public function index(PaginateRequest $request)
    {
        try {
            return PurchaseOrdersResource::collection($this->purchaseOrdersService->list($request));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to fetch purchase orders'], 422);
        }
    }

    public function store(PurchaseOrdersRequest $request)
    {
        try {
            $purchaseOrders =  $this->purchaseOrdersService->store($request);
            // dd($purchaseOrders);
            return new PurchaseOrdersResource($purchaseOrders);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to create purchase orders'], 422);
        }
    }

    public function update(PurchaseOrdersRequest $request)
    {
        try {
            $purchase = $this->purchaseOrdersService->update($request);
            return new PurchaseOrdersResource($purchase);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to update supplier'], 422);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $this->purchaseOrdersService->destroy($request);
            return response()->json(['status' => true, 'message' => 'Purchase order deleted successfully'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response(['status' => false, 'message' => 'Failed to delete Purchase order'], 422);
        }
    }
}
