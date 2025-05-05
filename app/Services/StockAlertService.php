<?php

namespace App\Services;

use App\Enums\Ask;
use App\Enums\Status;
use Exception;
use App\Models\ManageStock;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\PaginateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockAlertService
{
    public $item;
    protected $itemFilter = [
        'id',
        'name',
        'branch_id',
        'qty',
        'unit_id'
    ];

    public function list(PaginateRequest $request)
    {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : null;
            $orderColumn = $request->get('order_column') ?? 'manage_stocks.id';
            $orderType   = $request->get('order_type') ?? 'desc';

            $query = ManageStock::join('products', 'manage_stocks.product_id', '=', 'products.id')
                ->whereColumn('manage_stocks.qty', '<=', 'products.stock_alert')
                ->select(
                    'manage_stocks.id',
                    'manage_stocks.product_id',
                    'products.name',
                    'manage_stocks.qty',
                    'manage_stocks.branch_id',
                    'products.unit_id'
                );

            foreach ($requests as $key => $value) {
                if (in_array($key, $this->itemFilter) && $key !== 'except') {
                    $column = $key === 'name' ? 'products.name' : 'manage_stocks.' . $key;
                    $query->where($column, 'like', '%' . $value . '%');
                }
            }
            $query->orderBy($orderColumn, $orderType);
            $count = (clone $query)->count();

            $data = $method === 'paginate'
                ? $query->paginate($methodValue)
                : $query->get();

            return response()->json(['status' => true, 'count' => $count,'data' => $data]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}


