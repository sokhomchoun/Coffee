<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\ItemCategory;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\PaginateRequest;
use App\Models\Supplier;
use Response;

class ProductController extends AdminController
{
    public ProductService $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
        $this->middleware(['permission:unit'])->only('export');
        $this->middleware(['permission:product_create'])->only('store');
        $this->middleware(['permission:Product_edit'])->only('update');
        $this->middleware(['permission:product_delete'])->only('destroy');

    }

    public function brandList() {
        try {
            $brand = Brand::select('id','name','status')->where('status','=','Active')->get();
            return response(['status' => true, 'data' => $brand]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function unitList() {
        try {
            $unit = Unit::select('id','name','status')->where('status','=','Active')->get();
            return response(['status' => true, 'data' => $unit]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function branchList() {
        try {
            $branch = Branch::select('id','name')->get();
            return response(['status' => true, 'data' => $branch]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function categoryList() {
        try {
            $category = ItemCategory::select('id','name')->get();
            return response(['status' => true, 'data' => $category]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
    public function productList() {
        try {
            $products = Product::select('id','name')->get();
            return response(['status' => true, 'data' => $products]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
    public function supplierList() {
        try {
            $suppliers = Supplier::select('id','name')->get();
            return response(['status' => true, 'data' => $suppliers]);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ProductResource::collection($this->productService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(ProductRequest $request): \Illuminate\Http\Response | ProductResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory {
        try {
            return new ProductResource($this->productService->store($request));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(ProductRequest $request, Product $item): \Illuminate\Http\Response | ProductResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductResource($this->productService->update($request, $item));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy($id) {
        try {
            Product::where('id', $id)->delete();
            return response()->json([
                'success' => true,
            ], 201);
        } catch (Exception $exception) {
            return response(['status' => false,'message' => $exception->getMessage()], 422);
        }
    }

}
