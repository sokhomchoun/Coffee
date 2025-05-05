<?php

namespace App\Services;


use App\Enums\Ask;
use App\Enums\Status;
use Exception;
use App\Models\Variation;
use Illuminate\Support\Str;
use App\Http\Requests\VariationRequest;
use App\Http\Requests\PaginateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VariationService
{
    public $item = [];
    protected $itemFilter = [
        'id',
        'name',
        'type',
        'except'
    ];

    public function list(PaginateRequest $request) {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';

            return Variation::where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->itemFilter)) {
                        if ($key == "except") {
                            $explodes = explode('|', $request);
                            if (count($explodes)) {
                                foreach ($explodes as $explode) {
                                    $query->where('id', '!=', $explode);
                                }
                            }
                        } else {
                            if ($key == "id") {
                                $query->where($key, $request);
                            } else {
                                $query->where($key, 'like', '%' . $request . '%');
                            }
                        }
                    }
                }
            })->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(VariationRequest $request) {
        try {
            $variationTypes = is_string($request->type)
                ? json_decode($request->type, true)
                : $request->type;

            foreach ($variationTypes as $type) {
                $this->item = Variation::create([
                    'name' => $request->name,
                    'type' => $type,
                ]);
            }
            return $this->item;

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

}


