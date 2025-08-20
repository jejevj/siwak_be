<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TTaskSurvey;
use Illuminate\Http\Request;

class TTaskSurveyController extends Controller
{
    public function index()
    {
        return TTaskSurvey::all();
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'TaskID' => 'required|integer',
            'iduser' => 'nullable',
            'identitas_no' => 'nullable|string',
            'nama_surveyor' => 'nullable|string',
            'ID_Dir' => 'required|integer',
            'StatusTask' => 'required|integer',
            'StatusTanah' => 'nullable|string',
            'KetSurvey' => 'nullable|string',
            'KetVerify' => 'nullable|string',
            'idkuisoner' => 'nullable|integer',
            'verifikator' => 'nullable|string',
            'verified_at' => 'nullable|date',
            'CreatedDate' => 'nullable|date',
        ]);

        // Using updateOrCreate to either update or create the record
        $survey = TTaskSurvey::updateOrCreate(
            [
                'TaskID' => $data['TaskID'],  // Match TaskID (primary key)
                'ID_Dir' => $data['ID_Dir'],  // Match ID_Dir (optional if needed for uniqueness)
            ],
            $data  // Fields to update or create with
        );

        // Return the response
        return response()->json($survey, 201);
    }



    public function show($idDir)
    {
        // Find survey by ID_Dir
        $survey = TTaskSurvey::where('ID_Dir', $idDir)->first();

        // Check if the survey exists, if not return a 404 response
        if (!$survey) {
            return response()->json(['message' => 'Survey not found'], 404);
        }

        return response()->json($survey);
    }


    public function update(Request $request, $taskId)
    {
        // Validate the incoming data
        $data = $request->validate([
            'TaskID' => 'required|integer',
            'iduser' => 'nullable',
            'identitas_no' => 'nullable|string',
            'nama_surveyor' => 'nullable|string',
            'ID_Dir' => 'required|integer',
            'StatusTask' => 'required|integer',
            'StatusTanah' => 'nullable|string',
            'KetSurvey' => 'nullable|string',
            'KetVerify' => 'nullable|string',
            'idkuisoner' => 'nullable|integer',
            'verifikator' => 'nullable|string',
            'verified_at' => 'nullable|date',
            'CreatedDate' => 'nullable|date',
        ]);

        // Find the existing survey or create a new one
        $survey = TTaskSurvey::where('TaskID', $taskId)->first();

        if ($survey) {
            // Update the existing record
            $survey->update($data);
            return response()->json($survey, 200);  // Return updated record
        } else {
            // If not found, create a new one (or you can throw an error if needed)
            $survey = TTaskSurvey::create($data);
            return response()->json($survey, 201);  // Return newly created record
        }
    }

    public function destroy($id)
    {
        $survey = TTaskSurvey::findOrFail($id);
        $survey->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
