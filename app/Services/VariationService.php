<?php
namespace App\Services;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\VariationRequest;
use App\Http\Resources\VariationResource;
use App\Models\Variation;
use Exception;
use Google\Service\AnalyticsData\OrderBy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VariationService
{
    protected $itemFilter = [
        'id',
        'name',
        'type',
        'except',
    ];

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

            // Build the query with dynamic filters and eager load variation_types
            $variations = Variation::with('type')
                ->orderBy($orderColumn, $orderType)
                ->$method($methodValue);

            return $variations;

        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    // Store a new variation and its types
    public function store(VariationRequest $request)
    {
        DB::beginTransaction(); // Start a transaction to ensure both `Variation` and `VariationTypes` are saved correctly

        try {
            // Create the Variation
            $variation = Variation::create([
                'name' => $request->name,
            ]);

                                              // Create the related VariationTypes
            $variationTypes = $request->type; // This should be an array of types from the request

            foreach ($variationTypes as $type) {
                // Create each VariationType and associate it with the current Variation
                $variation->type()->create([
                    'name' => $type['name'], // Assuming 'name' is the field in `variation_types` table
                ]);
            }

            DB::commit();                             // Commit the transaction if everything is successful
            return new VariationResource($variation); // Return the newly created Variation with its types

        } catch (Exception $exception) {
            DB::rollBack(); // Rollback if there is any error
            Log::error('Error creating variation and types: ' . $exception->getMessage());
            throw new Exception('Failed to create variation and its types.', 422);
        }
    }

    // Update an existing variation and its types
    public function update(VariationRequest $request)
    {
        try {
            $variation = Variation::findOrFail($request->id);

            // Update the variation name
            $variation->update([
                'name' => $request->name,
            ]);

                                                                // Get the current types from the database associated with this variation
            $currentVariationTypes = $variation->type()->get(); // Fetch all types for this variation

                                                                                // Create an array of IDs from the incoming types
            $incomingTypeIds = collect($request->type)->pluck('id')->toArray(); // Get an array of incoming type IDs

            // Loop through the current types to delete the ones not in the incoming data
            foreach ($currentVariationTypes as $type) {
                // If the current type ID is not in the incoming IDs, delete it
                if (! in_array($type->id, $incomingTypeIds) && $type->id !== null) {
                    $type->delete();
                }
            }

            // Loop through the new or updated types and create or update them
            foreach ($request->type as $type) {
                if ($type['id']) {
                    // Update existing variation type by ID
                    $existingType = $variation->type()->findOrFail($type['id']);

                    if ($existingType) {
                        // Update the existing variation type
                        $existingType->update([
                            'name' => $type['name'],
                        ]);
                    }
                } else {
                    // Create new variation type if ID is null (new type)
                    $variation->type()->create([
                        'name' => $type['name'],
                    ]);
                }
            }

            DB::commit();                             // Commit the transaction if everything is successful
            return new VariationResource($variation); // Return the updated variation with its types
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack(); // Rollback in case of failure
            throw new Exception('Failed to update variation and its types.', 422);
        }
    }

    // Delete a variation and its types
    public function destroy($request)
    {
        try {
            $variation = Variation::findOrFail($request->id);
            $variation->type()->delete(); // Delete associated types
            $variation->delete();         // Delete the variation

            DB::commit();                             // Commit the transaction if everything is successful
            return new VariationResource($variation); // Return the newly created Variation with its types
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw new Exception('Failed to delete variation and its types.', 422);
        }
    }
}
