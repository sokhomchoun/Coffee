<?php

namespace App\Services;


use App\Enums\Ask;
use App\Enums\Status;
use Exception;
use App\Models\Unit;
use Illuminate\Support\Str;
use App\Http\Requests\UnitRequest;
use App\Http\Requests\PaginateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitService
{
    public $item;
    protected $itemFilter = [
        'id',
        'name',
        'status',
        'except'
    ];

    public function list(PaginateRequest $request) {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';

            return Unit::where(function ($query) use ($requests) {
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

    public function store(UnitRequest $request) {
        try {
            $this->item = Unit::create($request->validated() + ['slug' => Str::slug($request->name)]);
            return $this->item;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function update(UnitRequest $request, Unit $item): Unit {
        try {
            DB::transaction(function () use ($request, $item) {
                $item->update($request->validated() + ['slug' => Str::slug($request->name)]);
            });
            return $item;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

}


