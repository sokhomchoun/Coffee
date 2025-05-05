<?php
namespace App\Services;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\PurchaseOrdersRequest;
use App\Http\Resources\PurchaseOrdersResource;
use App\Models\purchaseItems;
use App\Models\purchaseOrders;
use App\Models\ManageStock;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrdersService
{

    public function list(PaginateRequest $request)
    {
        try {
            // Get all request parameters
            $requests = $request->all();

            // Determine if we should paginate or get all records
            $method      = $request->get('paginate') == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate') == 1 ? $request->get('per_page', 10) : '*';

            // Set default order column and type
            $orderColumn = $request->get('order_column', 'id');
            $orderType   = $request->get('order_type', 'desc');

            $purchaseOrders = purchaseOrders::with('purchaseItems')
                ->orderBy($orderColumn, $orderType)
                ->$method($methodValue);

            return $purchaseOrders;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(PurchaseOrdersRequest $request)
    {

        DB::beginTransaction();
        try {
            $purchase = purchaseOrders::create([
                'date'        => $request['date'],
                'supplier_id' => $request['supplier_id'],
                'branch_id'   => $request['branch_id'],
            ]);
            // Create related purchase items (child)
            foreach ($request['items'] as $item) {
                PurchaseItems::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $item['product_id'],
                    'unit'        => $item['unit'],
                    'qty'         => $item['qty'],
                ]);
                ManageStock::create([
                    'product_id'  => $item['product_id'],
                    'branch_id'   => $purchase->branch_id,
                    'qty'         => $item['qty'],
                ]);
            }

            DB::commit();
            return $purchase;
            // return new PurchaseOrdersResource($purchase);
        } catch (Exception $exception) {
            DB::rollBack(); // Rollback if there is any error
            Log::error('Error creating purchase order: ' . $exception->getMessage());
            throw new Exception('Failed to create purchase order.', 422);
        }
    }

    public function update(PurchaseOrdersRequest $request)
    {
        DB::beginTransaction();
        try {
            $suppliers = purchaseOrders::findOrFail($request->id);

            $suppliers->update([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone_number' => $request->phone_number,
                'country'      => $request->country,
                'city'         => $request->city,
                'address'      => $request->address,
            ]);

            DB::commit();
            return new PurchaseOrdersResource($suppliers);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack(); // Rollback in case of failure
            throw new Exception('Failed to update purchase order.', 422);
        }
    }

    public function destroy($request)
    {
        try {
            $suppliers = purchaseOrders::findOrFail($request->id);
            $suppliers->delete();
            DB::commit();
            return new PurchaseOrdersResource($suppliers);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw new Exception('Failed to delete purchase order.', 422);
        }
    }
}
