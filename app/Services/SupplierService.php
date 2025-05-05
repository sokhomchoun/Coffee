<?php
namespace App\Services;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierService
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
        
            $suppliers = Supplier::orderBy($orderColumn, $orderType)
                ->$method($methodValue);

            return $suppliers;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            $suppliers = Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
            ]);

            DB::commit();
            return new SupplierResource($suppliers);
        } catch (Exception $exception) {
            DB::rollBack(); // Rollback if there is any error
            Log::error('Error creating supplier: ' . $exception->getMessage());
            throw new Exception('Failed to create supplier.', 422);
        }
    }

    public function update(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            $suppliers = Supplier::findOrFail($request->id);

            $suppliers->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
            ]);

            DB::commit();
            return new SupplierResource($suppliers);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack(); // Rollback in case of failure
            throw new Exception('Failed to update supplier.', 422);
        }
    }

    public function destroy($request)
    {
        try {
            $suppliers = Supplier::findOrFail($request->id);
            $suppliers->delete();
            DB::commit();
            return new SupplierResource($suppliers);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw new Exception('Failed to delete supplier.', 422);
        }
    }
}
