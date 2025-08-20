<?php

namespace App\Http\Controllers;

use App\Models\DirWakaf;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DirWakafController extends Controller
{
    // Get all DirWakaf records
    public function index(Request $request)
    {
        try {
            // Validate the incoming request body parameters
            $validated = $request->validate([
                'Lokasi_Prop' => 'required|string',
                'Lokasi_Kab' => 'required|string',
            ]);

            // Fetch the data with filtering based on Lokasi_Prop and Lokasi_Kab
            $dirWakafs = DirWakaf::where('Lokasi_Prop', $validated['Lokasi_Prop'])
                ->where('Lokasi_Kab', $validated['Lokasi_Kab'])
                ->get();

            // Return the filtered data
            return response()->json($dirWakafs);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->errors(),
            ], 422);  // HTTP Status Code 422 Unprocessable Entity
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query errors (e.g., SQL errors)
            return response()->json([
                'error' => 'Database Query Error',
                'message' => $e->getMessage(),
            ], 500);  // HTTP Status Code 500 Internal Server Error
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                'error' => 'Unexpected Error',
                'message' => $e->getMessage(),
            ], 500);  // HTTP Status Code 500 Internal Server Error
        }
    }
    // Get a specific DirWakaf record by ID
    public function show($id)
    {
        $dirWakaf = DirWakaf::find($id);

        if (!$dirWakaf) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($dirWakaf);
    }

    // Create a new DirWakaf record
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Define the validation rules based on your data requirements
            'Lokasi_Prop' => 'required|integer',
            'Lokasi_Kab' => 'required|integer',
            // Continue with other fields...
        ]);

        $dirWakaf = DirWakaf::create($validated);
        return response()->json($dirWakaf, 201);
    }

    // Update a specific DirWakaf record by ID
    public function update(Request $request, $id)
    {
        $dirWakaf = DirWakaf::find($id);

        if (!$dirWakaf) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $dirWakaf->update($request->all());
        return response()->json($dirWakaf);
    }

    // Delete a specific DirWakaf record by ID
    public function destroy($id)
    {
        $dirWakaf = DirWakaf::find($id);

        if (!$dirWakaf) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $dirWakaf->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }
}
