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
        // Validate the incoming data without TaskID
        $data = $request->validate([
            // 'TaskID' is not included here, because it should be auto-incremented by the database
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

        // If KetSurvey is empty, create a new record. Otherwise, update the existing one
        if (empty($data['KetSurvey'])) {
            // Create a new record without specifying TaskID
            $survey = TTaskSurvey::create($data);
        } else {
            // Update the existing record using updateOrCreate
            $survey = TTaskSurvey::updateOrCreate(
                [
                    'ID_Dir' => $data['ID_Dir'],  // Optionally, use other fields for matching
                ],
                $data  // Fields to update or create with
            );
        }

        // Return the response (201 for creation, 200 for update)
        return response()->json($survey, empty($data['KetSurvey']) ? 201 : 200);
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
        // Validate the incoming data (exclude TaskID from validation because it is auto-incremented)
        $data = $request->validate([
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

        // Check if KetSurvey is empty or null, and create or update accordingly
        if (empty($data['KetSurvey'])) {
            // If KetSurvey is empty or null, create a new record (without TaskID)
            // Since TaskID is auto-incremented, it will be assigned by the database
            $survey = TTaskSurvey::create($data);

            // Return newly created record
            return response()->json($survey, 201);  // HTTP 201 for created record
        } else {
            // If KetSurvey has a value, attempt to find and update the existing record by TaskID, iduser, identitas_no, and ID_Dir
            $survey = TTaskSurvey::where('TaskID', $taskId)
                ->where('iduser', $data['iduser'])  // Check if iduser matches
                ->where('identitas_no', $data['identitas_no'])  // Check if identitas_no matches
                ->where('ID_Dir', $data['ID_Dir'])  // Check if ID_Dir matches
                ->first();

            if ($survey) {
                // Update the existing record with the new data
                $survey->update($data);

                // Return the updated record
                return response()->json($survey, 200);  // HTTP 200 for updated record
            } else {
                // If no existing record is found, check if any record exists with the same iduser and ID_Dir
                $existingRecord = TTaskSurvey::where('iduser', $data['iduser'])
                    ->where('ID_Dir', $data['ID_Dir'])
                    ->first();

                if ($existingRecord) {
                    // If a matching record exists, delete it
                    $existingRecord->delete();
                }

                // Create a new record with the given data
                $survey = TTaskSurvey::create($data);

                // Return newly created record
                return response()->json($survey, 201);  // HTTP 201 for created record
            }
        }
    }



    public function destroy($id)
    {
        $survey = TTaskSurvey::findOrFail($id);
        $survey->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
