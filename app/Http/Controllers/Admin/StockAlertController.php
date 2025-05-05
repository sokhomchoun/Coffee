<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\ManageStock;
use App\Services\StockAlertService;
use Illuminate\Http\Request;
use App\Http\Resources\StockAlertResource;
use App\Http\Requests\PaginateRequest;
use Response;

class StockAlertController extends AdminController
{
    public StockAlertService $StockAlertService;

    public function __construct(StockAlertService $stockAlertService)
    {
        parent::__construct();
        $this->stockAlertService = $stockAlertService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return $this->stockAlertService->list($request);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

}
