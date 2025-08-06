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
        $data = $request->validate([
            'TaskID' => 'required|integer',
            'iduser' => 'required|integer',
            'identitas_no' => 'required|string',
            'nama_surveyor' => 'required|string',
            'ID_Dir' => 'required|integer',
            'StatusTask' => 'required|integer',
            'StatusTanah' => 'required|string',
            'KetSurvey' => 'nullable|string',
            'KetVerify' => 'nullable|string',
            'idkuisoner' => 'required|integer',
            'verifikator' => 'nullable|string',
            'verified_at' => 'nullable|date',
            'CreatedDate' => 'required|date',
        ]);

        $survey = TTaskSurvey::create($data);

        return response()->json($survey, 201);
    }

    public function show($id)
    {
        return TTaskSurvey::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $survey = TTaskSurvey::findOrFail($id);

        $data = $request->validate([
            'iduser' => 'sometimes|required|integer',
            'identitas_no' => 'sometimes|required|string',
            'nama_surveyor' => 'sometimes|required|string',
            'ID_Dir' => 'sometimes|required|integer',
            'StatusTask' => 'sometimes|required|integer',
            'StatusTanah' => 'sometimes|required|string',
            'KetSurvey' => 'nullable|string',
            'KetVerify' => 'nullable|string',
            'idkuisoner' => 'sometimes|required|integer',
            'verifikator' => 'nullable|string',
            'verified_at' => 'nullable|date',
            'CreatedDate' => 'sometimes|required|date',
        ]);

        $survey->update($data);

        return response()->json($survey);
    }

    public function destroy($id)
    {
        $survey = TTaskSurvey::findOrFail($id);
        $survey->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
